<?php

namespace common\services\mail;

use common\models\mail\MailLog;
use yii\base\BaseObject;

/**
 * Class MailLogService
 * @package common\services\mail
 */
class MailLogService extends BaseObject
{
    /**
     * @param $emailFrom
     * @param $emailTo
     * @param $subject
     * @param $text
     * @param $html
     * @param $result
     * @return MailLog
     * @throws \Exception
     */
    public function log($emailFrom, $emailTo, $subject, $text, $html, $result)
    {
        /** @var MailLog $mailLog */
        $mailLog = new MailLog();
        $mailLog->from = $emailFrom;
        $mailLog->to = $emailTo;
        $mailLog->subject = $subject;
        $mailLog->text = $text;
        $mailLog->html = $html;

        $result ? $mailLog->setStatusSend() : $mailLog->setStatusNotSend();

        if (!$mailLog->validate()) {
            throw new \Exception('Ошибка валидации при логировании письма');
        }

        if (!$mailLog->save()) {
            throw new \Exception('Ошибка сохрания лога отправляемого пьсьма');
        }

        return $mailLog;
    }
}
