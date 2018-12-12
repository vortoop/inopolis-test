<?php

namespace frontend\forms;

use yii\base\Model;

/**
 * Class UserForm
 * @package frontend\forms
 *
 * @property $username [string]
 */
class UserForm extends Model
{
    /** @var string */
    public $username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'filter', 'filter' => 'strip_tags'],
            ['username', 'required'],
            ['username', 'string']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя'
        ];
    }
}
