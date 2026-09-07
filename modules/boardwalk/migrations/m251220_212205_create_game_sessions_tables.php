<?php

use yii\db\Migration;

class m251220_212205_create_game_sessions_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%game_sessions}}', [
            'id' => $this->primaryKey(),
            'game_id' => $this->integer()->notNull(),
            'start_at' => $this->dateTime()->notNull(),
            'end_at' => $this->dateTime(),
            'seats_total' => $this->integer()->notNull()->defaultValue(4),
            'seats_taken' => $this->integer()->notNull()->defaultValue(0),
            'address' => $this->string(255)->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'status' => $this->string(20)->notNull()->defaultValue('planned'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-board_game_sessions-game_id', '{{%game_sessions}}', 'game_id');
        $this->addForeignKey(
            'fk-board_game_sessions-game_id',
            '{{%game_sessions}}',
            'game_id',
            '{{%games}}',
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
        $this->dropIndex('idx-board_game_sessions-game_id', '{{%game_sessions}}');
        $this->dropForeignKey('fk-board_game_sessions-game_id', '{{%game_sessions}}');
        $this->dropTable('{{%game_sessions}}');
    }
}
