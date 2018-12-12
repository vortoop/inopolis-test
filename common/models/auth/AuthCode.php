<?php

namespace common\models\auth;

use common\interfaces\StatusInterface;
use common\models\User;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_code".
 *
 * @property int $id
 * @property string $email
 * @property string $auth_code
 * @property int $status
 * @property int $created_at [timestamp(0) with time zone]
 * @property int $updated_at [timestamp(0) with time zone]
 *
 * @property User $user
 */
class AuthCode extends ActiveRecord implements StatusInterface
{
    const STATUS_USES = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_code';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'filter', 'filter' => 'trim'],
            [['email'], 'filter', 'filter' => 'strip_tags'],
            [['email'], 'email'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [
                ['status'],
                'in',
                'range' => [AuthCode::STATUS_ACTIVE, AuthCode::STATUS_USES]
            ],
            [['auth_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'auth_code' => 'Код авторизации',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['email' => 'email']);
    }

    /**
     * @inheritdoc
     */
    public function setStatusActive(): void
    {
        $this->status = static::STATUS_ACTIVE;
    }

    /**
     * @inheritdoc
     */
    public function setStatusUses(): void
    {
        $this->status = static::STATUS_USES;
    }

    /**
     * Устанока статуса "Не активный"
     */
    public function setStatusNonActive(): void
    {
        $this->status = static::STATUS_NON_ACTIVE;
    }

    /**
     * Имеет ли сущность статус "активный"
     * @return bool
     */
    public function isStatusActive(): bool
    {
        return $this->status == static::STATUS_ACTIVE;
    }

    /**
     * Имеет ли сущность статус "не активный"
     * @return bool
     */
    public function isStatusNonActive(): bool
    {
        return $this->status == static::STATUS_NON_ACTIVE;
    }

    /**
     * Имеет ли сущность статус "использован"
     * @return bool
     */
    public function isStatusUses(): bool
    {
        return $this->status == static::STATUS_USES;
    }
}
