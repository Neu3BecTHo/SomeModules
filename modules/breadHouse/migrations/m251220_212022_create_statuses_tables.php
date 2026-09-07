<?php

use yii\db\Migration;

class m251220_212022_create_statuses_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%statuses}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
        ]);

        $this->batchInsert('{{%statuses}}', ['title'], [
            ['Новый'],
            ['Подтверждён'],
            ['В процессе'],
            ['Доставлен'],
            ['Отменён'],
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
