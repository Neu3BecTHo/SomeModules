<?php

use yii\db\Migration;

class m251220_212205_create_orders_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer()->notNull(),
            'category_id'     => $this->integer()->notNull(),
            'status_id'       => $this->integer()->notNull()->defaultValue(1),
            'address'         => $this->string(255)->notNull(),
            'payment_type'    => $this->string(20)->notNull(),
            'extra_info'      => $this->text()->null(),
            'item_type'       => $this->string(100)->null(),
            'material'        => $this->string(100)->null(),
            'pollution_level' => $this->string(50)->null(),
            'carpet_size'     => $this->string(50)->null(),
            'created_at'      => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-cleaner-order-user_id',
            '{{%orders}}',
            'user_id'
        );

        $this->createIndex(
            'idx-cleaner-order-category_id',
            '{{%orders}}',
            'category_id'
        );

        $this->createIndex(
            'idx-cleaner-order-status_id',
            '{{%orders}}',
            'status_id'
        );

        $this->addForeignKey(
            'fk-cleaner-orders-user_id',
            '{{%orders}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-cleaner-orders-category_id',
            '{{%orders}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-cleaner-orders-status_id',
            '{{%orders}}',
            'status_id',
            '{{%statuses}}',
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
        $this->dropForeignKey('fk-cleaner-orders-user_id', '{{%orders}}');
        $this->dropForeignKey('fk-cleaner-orders-category_id', '{{%orders}}');
        $this->dropForeignKey('fk-cleaner-orders-status_id', '{{%orders}}');
        $this->dropIndex('idx-cleaner-order-user_id', '{{%orders}}');
        $this->dropIndex('idx-cleaner-order-category_id', '{{%orders}}');
        $this->dropIndex('idx-cleaner-order-status_id', '{{%orders}}');
        $this->dropTable('{{%orders}}');
    }
}
