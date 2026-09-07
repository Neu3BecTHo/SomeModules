<?php

use yii\db\Migration;

class m251220_212356_create_reviews_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id'         => $this->primaryKey(),
            'order_id'   => $this->integer()->notNull(),
            'user_id'    => $this->integer()->notNull(),
            'rating'     => $this->tinyInteger()->notNull(),
            'comment'    => $this->text()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-cleaner-reviews-order_id', '{{%reviews}}', 'order_id');
        $this->createIndex('idx-cleaner-reviews-user_id', '{{%reviews}}', 'user_id');

        $this->addForeignKey(
            'fk-cleaner-reviews-order_id',
            '{{%reviews}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-cleaner-reviews-user_id',
            '{{%reviews}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-cleaner-reviews-order_id', '{{%reviews}}');
        $this->dropForeignKey('fk-cleaner-reviews-user_id', '{{%reviews}}');

        $this->dropIndex('idx-cleaner-reviews-order_id', '{{%reviews}}');
        $this->dropIndex('idx-cleaner-reviews-user_id', '{{%reviews}}');
        $this->dropTable('{{%reviews}}');
    }
}
