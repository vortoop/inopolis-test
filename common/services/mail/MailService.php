<?php

namespace common\services\mail;

use common\models\auth\AuthCode;
use common\services\auth\AuthCodeService;
use yii\helpers\Html;
use yii\base\BaseObject;

/**
 * Class MailService
 * @package common\services\mail
 *
 * @property string $emailFrom
 */
class MailService extends BaseObject
{
    /** @var string */
    protected $emailFrom;

    /**
     * MailService constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->emailFrom = \Yii::$app->params['supportEmail'];
        parent::__construct($config);
    }

    /**
     * @param $emailTo
     * @return bool
     * @throws \Exception
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function sendMessageAuth($emailTo)
    {
        $authCode = \Yii::$app->security->generateRandomString();
        $link = Html::a(
            'ссылке',
            $_ENV['YII_PRODUCT_SETTINGS']['general']['domain'] . '/site/login?authCode=' . $authCode
        );

        $message = 'Перейдите по ссылке для авторизации: ' . $link;
        $subject = 'Авторизация на сайте: ' . $_ENV['YII_PRODUCT_SETTINGS']['general']['site-name'];

        $result = \Yii::$app->mailer->compose()
            ->setFrom($this->emailFrom)
            ->setTo($emailTo)
            ->setSubject($subject)
            ->setTextBody($message)
            ->setHtmlBody($message)
            ->send();

        if (!$result) {
            \Yii::$app->session->setFlash('danger', 'Не удалось отправить письмо на указанный вами адрес');
            return false;
        }

        $logMailService = new MailLogService();
        $authService = new AuthCodeService();

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $logMailService->log($this->emailFrom, $emailTo, $subject, $message, $message, $result);
            AuthCode::updateAll(
                ['status' => AuthCode::STATUS_NON_ACTIVE],
                ['email' => $emailTo, 'status' => AuthCode::STATUS_ACTIVE]
            );

            $authService->create($emailTo, $authCode);
            $transaction->commit();
            \Yii::$app->session->setFlash('success', 'На Ваш Email отправленно письмо со ссылкой для авторизации');
        } catch (\Exception $exception) {
            \Yii::error('Ошибка отправки сообщения пользователю при авторизации. Email: ' . $emailTo ?? '');
            $transaction->rollBack();
            throw $exception;
        }
    }
}
