<?php

use yii\db\Migration;

class m251220_174545_create_requests_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%requests}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'service_type_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull()->defaultValue(1),
            
            'date_submitted' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            
            'previous_value' => $this->decimal(10, 2)->notNull(),
            'current_value' => $this->decimal(10, 2)->notNull(),
            
            'consumption' => $this->decimal(10, 2)->notNull(),
            'tariff_snapshot' => $this->decimal(10, 2)->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-comm_requests-user_id', '{{%requests}}', 'user_id');
        $this->addForeignKey(
            'fk-comm_requests-user_id',
            '{{%requests}}',
            'user_id',
            '{{%users}}', // comm_users
            'id',
            'CASCADE'
        );

        $this->createIndex('idx-comm_requests-service_type_id', '{{%requests}}', 'service_type_id');
        $this->addForeignKey(
            'fk-comm_requests-service_type_id',
            '{{%requests}}',
            'service_type_id',
            '{{%service_types}}',
            'id',
            'RESTRICT'
        );

        $this->createIndex('idx-comm_requests-status_id', '{{%requests}}', 'status_id');
        $this->addForeignKey(
            'fk-comm_requests-status_id',
            '{{%requests}}',
            'status_id',
            '{{%request_statuses}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-comm_requests-user_id', '{{%requests}}');
        $this->dropIndex('idx-comm_requests-service_type_id', '{{%requests}}');
        $this->dropIndex('idx-comm_requests-status_id', '{{%requests}}');
        
        $this->dropForeignKey('fk-comm_requests-status_id', '{{%requests}}');
        $this->dropForeignKey('fk-comm_requests-service_type_id', '{{%requests}}');
        $this->dropForeignKey('fk-comm_requests-user_id', '{{%requests}}');
        
        $this->dropTable('{{%requests}}');
    }
}
