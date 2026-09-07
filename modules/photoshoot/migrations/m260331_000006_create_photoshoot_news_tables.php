<?php

use yii\db\Migration;

class m260331_000006_create_photoshoot_news_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'type' => $this->string(50)->notNull(),
            'image' => $this->string(255),
            'date_start' => $this->date(),
            'date_end' => $this->date(),
            'is_active' => $this->integer()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
