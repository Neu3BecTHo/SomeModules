<?php

use yii\db\Migration;

class m251220_211606_create_users_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id'            => $this->primaryKey(),
            'first_name'    => $this->string(100)->notNull(),
            'last_name'     => $this->string(100)->notNull(),
            'patronymic'    => $this->string(100)->notNull(),
            'phone'         => $this->string()->notNull()->unique(),
            'password'      => $this->string()->notNull(),
            'is_admin'      => $this->boolean()->notNull()->defaultValue(false),
            'auth_key'      => $this->string(32)->null(),
            'password_reset_token' => $this->string()->unique()->null(),
            'created_at'    => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
