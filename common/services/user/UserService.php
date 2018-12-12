<?php

namespace common\services\user;

use common\models\User;
use yii\base\BaseObject;

/**\
 * Class UserService
 * @package common\services\user
 */
class UserService extends BaseObject
{
    /**
     * @param $email
     * @return bool|User
     * @throws \yii\base\Exception
     */
    public function create($email)
    {
        $user = new User();
        $user->username = \Yii::$app->security->generateRandomString(12);
        $user->email = $email;
        $user->status = User::STATUS_ACTIVE;
        $user->generateAuthKey();

        if (!$user->save()) {
            return false;
        }

        return $user;
    }
}
