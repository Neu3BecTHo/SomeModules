<?php

use yii\db\Migration;

class m251220_174447_create_statuses_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_statuses}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'code' => $this->string(50)->notNull()->unique(),
        ]);

        // Данные по ТЗ: Новая, Показания приняты, Ошибка
        $this->batchInsert('{{%request_statuses}}', ['title', 'code'], [
            ['Новая', 'new'],
            ['Показания приняты', 'approved'],
            ['Ошибка в переданных показаниях', 'error'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request_statuses}}');
    }
}
