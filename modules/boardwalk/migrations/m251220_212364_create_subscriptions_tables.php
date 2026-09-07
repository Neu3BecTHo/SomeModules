<?php

use yii\db\Migration;

class m251220_212364_create_subscriptions_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull()->unique(),
            'confirmed_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'unsubscribed_at' => $this->integer(),
            'token' => $this->string(64),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscriptions}}');
    }
}
