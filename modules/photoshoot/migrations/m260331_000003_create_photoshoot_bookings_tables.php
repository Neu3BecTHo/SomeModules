<?php

use yii\db\Migration;

class m260331_000003_create_photoshoot_bookings_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%bookings}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'service_type' => $this->string(50)->notNull(),
            'hall_type' => $this->string(50),
            'duration' => $this->string(50)->notNull(),
            'photo_session_type' => $this->string(50),
            'booking_date' => $this->dateTime()->notNull(),
            'people_count' => $this->integer()->notNull(),
            'wishes' => $this->text(),
            'payment_method' => $this->string(50)->notNull(),
            'status' => $this->string(50)->notNull()->defaultValue('new'),
            'total_price' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-photoshoot-bookings-user_id',
            '{{%bookings}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-photoshoot-bookings-user_id', '{{%bookings}}');
        $this->dropTable('{{%bookings}}');
    }
}
