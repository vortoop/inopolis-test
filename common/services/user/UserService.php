<?php

namespace common\services\user;

use common\models\User;
use frontend\forms\UserForm;
use yii\base\BaseObject;

/**\
 * Class UserService
 * @package common\services\user
 */
class UserService extends BaseObject
{
    /** @var User */
    protected $_model;

    /**
     * UserService constructor.
     * @param User $model
     * @param array $config
     */
    public function __construct(User $model, array $config = [])
    {
        $this->_model = $model;
        parent::__construct($config);
    }

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

    /**
     * @param array $attributes
     * @return User
     * @throws \Exception
     */
    public function update(array $attributes)
    {
        $model = $this->getModel();
        $modelForm = new UserForm();
        $modelForm->setAttributes($attributes);

        if (!$modelForm->validate()) {
            \Yii::error('Ошибка валидации. ' . __METHOD__);
            throw new \Exception('Указаны не верные данные.');
        }

        $model->setAttributes($modelForm->getAttributes());
        if (!$model->save()) {
            \Yii::error('Не удалось обновить пользователя' . __METHOD__);
            throw new \Exception('Не удалось обновить пользователя.');
        }

        return $model;
    }

    /**
     * @return User
     */
    public function getModel(): User
    {
        return $this->_model;
    }
}
