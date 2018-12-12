<?php

namespace common\services\auth;

use common\models\auth\AuthCode;
use yii\base\BaseObject;

/**
 * Class AuthService
 * @package common\services\auth
 */
class AuthCodeService extends BaseObject
{
    /**
     * @param string $email
     * @param integer $authCode
     * @throws \Exception
     * @return AuthCode
     */
    public function create($email, $authCode)
    {
        $auth = new AuthCode();
        $auth->email = $email;
        $auth->auth_code = $authCode;
        $auth->setStatusActive();

        if (!$auth->validate()) {
            throw new \Exception('Неверный формат email или кода вторизации');
        }

        if (!$auth->save()) {
            throw new \Exception('Ошибка при сохранении лога кода автоизации');
        }

        return $auth;
    }
}
