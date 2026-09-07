<?php

use yii\db\Migration;

class m251220_212023_create_categories_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
        ]);

        $this->batchInsert('{{%categories}}', ['title'], [
            ['Химчистка обуви'],
            ['Химчистка верхней одежды'],
            ['Химчистка мягкой мебели'],
            ['Химчистка ковровых покрытий'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
