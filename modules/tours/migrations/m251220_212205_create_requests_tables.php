<?php

use yii\db\Migration;

class m251220_212205_create_requests_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%requests}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'tour_id' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'participants_count' => $this->integer()->notNull()->defaultValue(1),
            'options' => $this->string(255)->null(),
            'wishes' => $this->string(255)->null(),
            'comment' => $this->text()->null(),
            'payment_method' => $this->string(50)->notNull(),
            'status' => $this->string(30)->notNull()->defaultValue('new'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-tour_requests-user_id',
            '{{%requests}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tour_requests-tour_id',
            '{{%requests}}',
            'tour_id',
            '{{%tours}}',
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
        $this->dropForeignKey('fk-tour_requests-user_id', '{{%requests}}');
        $this->dropForeignKey('fk-tour_requests-tour_id', '{{%requests}}');
        $this->dropTable('{{%requests}}');
    }
}
