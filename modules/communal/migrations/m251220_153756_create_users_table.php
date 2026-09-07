<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m251220_153756_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),

            'password' => $this->string()->notNull(),
            'firstName' => $this->string()->notNull(),
            'lastName' => $this->string()->notNull(),
            'patronymic' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'residents_count' => $this->integer()->notNull(),
            'rules' => $this->boolean()->notNull()->defaultValue(false),

            'authKey' => $this->string(32),
            'accessToken' => $this->string()->unique(),

            'createdAt' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
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
