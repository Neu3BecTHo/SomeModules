<?php

use yii\db\Migration;

class m251220_212358_create_reviews_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'author_name' => $this->string(255)->notNull(),
            'text' => $this->text()->notNull(),
            'rating' => $this->integer(),
            'is_published' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-board_reviews-user_id', '{{%reviews}}', 'user_id');
        $this->addForeignKey(
            'fk-board_reviews-user_id',
            '{{%reviews}}',
            'user_id',
            '{{%users}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-board_reviews-user_id', '{{%reviews}}');
        $this->dropForeignKey('fk-board_reviews-user_id', '{{%reviews}}');
        $this->dropTable('{{%reviews}}');
    }
}
