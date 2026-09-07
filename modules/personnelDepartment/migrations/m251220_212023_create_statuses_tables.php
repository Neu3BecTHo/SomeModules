<?php

use yii\db\Migration;

class m251220_212023_create_statuses_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%statuses}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->notNull()->unique(),
            'title' => $this->string(255)->notNull(),
        ]);

        $this->batchInsert('{{%statuses}}', ['code', 'title'], [
            ['new', 'Новая'],
            ['checking', 'Идет проверка данных'],
            ['approved', 'Данные приняты'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%statuses}}');
    }
}
