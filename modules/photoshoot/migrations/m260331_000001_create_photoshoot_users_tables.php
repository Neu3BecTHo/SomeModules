<?php

use yii\db\Migration;

class m260331_000001_create_photoshoot_users_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(50)->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'full_name' => $this->string(200)->notNull(),
            'phone' => $this->string(20)->notNull()->unique(),
            'email' => $this->string(100)->notNull()->unique(),
            'accessToken' => $this->string()->unique(),
            'authKey' => $this->string(32),
            'is_admin' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create default admin user: FotoAdmin / FotoAdmin123
        $this->insert('{{%users}}', [
            'login' => 'FotoAdmin',
            'password' => Yii::$app->security->generatePasswordHash('FotoAdmin123'),
            'full_name' => 'Администратор Фотостудии',
            'phone' => '+7(999)999-99-99',
            'email' => 'admin@moistorii.ru',
            'is_admin' => 1,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
