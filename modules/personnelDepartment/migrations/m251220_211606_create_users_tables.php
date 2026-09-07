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
            'patronymic' => $this->string(100),
            'phone' => $this->string(20)->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'rules' => $this->boolean()->notNull()->defaultValue(false),
            'authKey' => $this->string(255),
            'accessToken' => $this->string(255),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-pers_personnelDepartment-users_phone', '{{%users}}', 'phone', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-pers_personnelDepartment-users_phone', '{{%users}}');
        $this->dropTable('{{%users}}');
    }
}
