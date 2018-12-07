<?php

namespace frontend\forms;

/**
 * Форма для авторизации или регистрации (при необходимости) пользователя
 * Class AuthForm
 */
class AuthForm extends \yii\base\Model
{
    /** Сценарии для авторизации */
    const
        SCENARIO_EMAIL = 'auth-email',
        SCENARIO_PASS = 'auth-password';

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'filter', 'filter' => 'trim'],
            [['email', 'password'], 'filter', 'filter' => 'strip_tags'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6, 'max' => 72],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            static::SCENARIO_EMAIL => ['email'],
            static::SCENARIO_PASS => ['password'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    /**
     * @inheritdoc
     */
    public function setScenarioEmail(): void
    {
        $this->setScenario(static::SCENARIO_EMAIL);
    }

    /**
     * @inheritdoc
     */
    public function setScenarioPass(): void
    {
        $this->setScenario(static::SCENARIO_PASS);
    }

    /**
     * @return bool
     */
    public function isAssignEmailScenario(): bool
    {
        return $this->scenario == static::SCENARIO_EMAIL;
    }

    /**
     * @return bool
     */
    public function isAssignPassScenario(): bool
    {
        return $this->scenario == static::SCENARIO_PASS;
    }
}
