<?php

use yii\db\Migration;

class m251220_212023_create_games_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%games}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(50)->notNull(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->unique(),
            'short_description' => $this->string(500),
            'description' => $this->text(),
            'min_players' => $this->integer(),
            'max_players' => $this->integer(),
            'min_age' => $this->integer(),
            'duration_minutes' => $this->integer(),
            'is_popular' => $this->boolean()->notNull()->defaultValue(false),
            'image' => $this->string(255),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%games}}');
    }
}
