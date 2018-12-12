<?php

use common\models\auth\AuthCode;
use yii\db\Migration;

/**
 * Class m181209_150003_create_tbl_auth_code
 */
class m181209_150003_create_tbl_auth_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auth_code', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'auth_code' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(AuthCode::STATUS_ACTIVE),
            'created_at' => 'timestamp with time zone default NOW()',
            'updated_at' => 'timestamp with time zone default NOW()',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('auth_code');
    }
}
