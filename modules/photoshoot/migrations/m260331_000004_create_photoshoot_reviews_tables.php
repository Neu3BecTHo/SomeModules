<?php

use yii\db\Migration;

class m260331_000004_create_photoshoot_reviews_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'booking_id' => $this->integer()->notNull(),
            'rating' => $this->integer()->notNull(),
            'comment' => $this->text()->notNull(),
            'is_published' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-photoshoot-reviews-user_id',
            '{{%reviews}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-photoshoot-reviews-booking_id',
            '{{%reviews}}',
            'booking_id',
            '{{%bookings}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-photoshoot-reviews-booking_id',
            '{{%reviews}}',
            'booking_id',
            true
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-photoshoot-reviews-user_id', '{{%reviews}}');
        $this->dropForeignKey('fk-photoshoot-reviews-booking_id', '{{%reviews}}');
        $this->dropIndex('idx-photoshoot-reviews-booking_id', '{{%reviews}}');
        $this->dropTable('{{%reviews}}');
    }
}
