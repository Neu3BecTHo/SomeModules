<?php

use yii\db\Migration;

/**
 * Add email column to users table
 */
class m260214_000000_add_email_to_users extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'email', $this->string(255)->notNull()->unique());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'email');
    }
}
