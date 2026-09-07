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
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'tour_id' => $this->integer()->notNull(),
            'request_id' => $this->integer()->null(),
            'rating' => $this->integer()->notNull()->defaultValue(5),
            'text' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-tour_reviews-user_id',
            '{{%reviews}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tour_reviews-tour_id',
            '{{%reviews}}',
            'tour_id',
            '{{%tours}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tour_reviews-request_id',
            '{{%reviews}}',
            'request_id',
            '{{%requests}}',
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
        $this->dropForeignKey('fk-tour_reviews-user_id', '{{%reviews}}');
        $this->dropForeignKey('fk-tour_reviews-tour_id', '{{%reviews}}');
        $this->dropForeignKey('fk-tour_reviews-request_id', '{{%reviews}}');
        $this->dropTable('{{%reviews}}');
    }
}
