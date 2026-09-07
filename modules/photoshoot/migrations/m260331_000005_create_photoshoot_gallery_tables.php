<?php

use yii\db\Migration;

class m260331_000005_create_photoshoot_gallery_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%gallery}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'category' => $this->string(50)->notNull(),
            'image' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'is_active' => $this->integer()->defaultValue(1),
            'sort_order' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%gallery}}');
    }
}
