<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**\
 * Class LoginForm
 * @package common\models
 *
 * @property $email [string]
 */
class LoginForm extends Model
{
    /** @var string */
    public $email;

    /** @var User */
    private $_user;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
