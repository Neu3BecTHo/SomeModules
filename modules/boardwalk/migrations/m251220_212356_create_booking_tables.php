<?php

use yii\db\Migration;

class m251220_212356_create_booking_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking}}', [
            'id' => $this->primaryKey(),
            'session_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'name' => $this->string(255)->notNull(),
            'phone' => $this->string(50)->notNull(),
            'email' => $this->string(255),
            'payment_method' => $this->string(50)->notNull(),
            'player_status' => $this->string(50)->notNull(),
            'game_type' => $this->string(50)->notNull(),
            'players_count' => $this->integer()->notNull()->defaultValue(1),
            'status' => $this->string(20)->notNull()->defaultValue('new'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-board_booking-session_id', '{{%booking}}', 'session_id');
        $this->addForeignKey(
            'fk-board_booking-session_id',
            '{{%booking}}',
            'session_id',
            '{{%game_sessions}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-board_booking-user_id', '{{%booking}}', 'user_id');
        $this->addForeignKey(
            'fk-board_booking-user_id',
            '{{%booking}}',
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
        $this->dropIndex('idx-board_booking-user_id', '{{%booking}}');
        $this->dropIndex('idx-board_booking-session_id', '{{%booking}}');
        $this->dropForeignKey('fk-board_booking-user_id', '{{%booking}}');
        $this->dropForeignKey('fk-board_booking-session_id', '{{%booking}}');
        $this->dropTable('{{%booking}}');
    }
}
