<?php

namespace common\models\mail;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "mail_log".
 *
 * @property int $id
 * @property string $from
 * @property string $to
 * @property string $subject
 * @property string $text
 * @property string $html
 * @property string $status
 * @property string $created_at
 */
class MailLog extends ActiveRecord
{
    const
        STATUS_IS_SEND = 5,
        STATUS_NOT_SEND = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_log';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    'value' => new Expression('NOW()'),
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'html', 'subject'], 'string'],
            [['from', 'to'], 'string', 'max' => 255],
            [['status'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'От кого',
            'to' => 'Кому',
            'subject' => 'Тема письма',
            'text' => 'Текст письма',
            'html' => 'Разметка',
            'status' => 'Статус отправки письма',
            'created_at' => 'Создано в',
        ];
    }

    /**
     * @inheritdoc
     */
    public function setStatusSend(): void
    {
        $this->status = static::STATUS_IS_SEND;
    }

    /**
     * @inheritdoc
     */
    public function setStatusNotSend(): void
    {
        $this->status = static::STATUS_NOT_SEND;
    }

    /**
     * @return bool
     */
    public function isStatusSend(): bool
    {
        return $this->status == static::STATUS_IS_SEND;
    }

    /**
     * @return bool
     */
    public function isStatusNotSend(): bool
    {
        return $this->status == static::STATUS_NOT_SEND;
    }
}
