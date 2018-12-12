<?php

use common\models\mail\MailLog;
use yii\db\Migration;

/**
 * Class m181207_174009_create_tbl_mail_log
 */
class m181207_174009_create_tbl_mail_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('mail_log', [
            'id' => $this->primaryKey(),
            'from' => $this->string()->comment('От кого'),
            'to' => $this->string()->comment('Кому'),
            'subject' => $this->string()->comment('Тема сообщения'),
            'text' => $this->text()->comment('Текст сообщения'),
            'html' => $this->text()->comment('Разметка сообщения'),
            'status' => $this->integer()->notNull()->defaultValue(MailLog::STATUS_IS_SEND)->comment('Статус сообщения'),
            'created_at' => 'timestamp with time zone default NOW()',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('mail_log');
    }
}
