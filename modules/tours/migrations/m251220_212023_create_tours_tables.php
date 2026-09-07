<?php

use yii\db\Migration;

class m251220_212023_create_tours_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tours}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
            'slug' => $this->string(150)->notNull()->unique(),
            'short_description' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'image' => $this->string(255),
            'duration_days' => $this->integer()->notNull()->defaultValue(1),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tours}}');
    }
}
