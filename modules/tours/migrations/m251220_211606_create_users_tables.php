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
            'id' => $this->primaryKey(),
            'first_name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100)->notNull(),
            'patronymic' => $this->string(100)->notNull(),
            'password' => $this->string()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'email' => $this->string(100)->notNull()->unique(),
            'passport_series' => $this->string(4)->notNull(),
            'passport_number' => $this->string(6)->notNull(),
            'address' => $this->string(255)->notNull(),
            'accessToken' => $this->string()->unique(),
            'authKey' => $this->string(32),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
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
