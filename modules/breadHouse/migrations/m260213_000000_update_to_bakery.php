<?php

use yii\db\Migration;

/**
 * Update breadHouse module to bakery "Хлебный дворик"
 */
class m260213_000000_update_to_bakery extends Migration
{
    public function safeUp()
    {
        // Drop foreign key to allow truncate
        $this->dropForeignKey('fk-orders-category_id', '{{%orders}}');

        // Update categories to bakery categories
        $this->execute('TRUNCATE TABLE {{%categories}}');
        $this->batchInsert('{{%categories}}', ['title'], [
            ['Хлеб'],
            ['Булочки'],
            ['Десерты'],
            ['Сезонные позиции'],
        ]);

        // Add foreign key back
        $this->addForeignKey('fk-orders-category_id', '{{%orders}}', 'category_id', '{{%categories}}', 'id', 'CASCADE', 'CASCADE');

        // Add new columns to orders table for bakery
        $this->addColumn('{{%orders}}', 'delivery_type', $this->string(20)->notNull()->defaultValue('pickup'));
        $this->addColumn('{{%orders}}', 'delivery_address', $this->string(255)->null());
        $this->addColumn('{{%orders}}', 'delivery_time', $this->datetime()->null());
        $this->addColumn('{{%orders}}', 'payment_method', $this->string(20)->notNull()->defaultValue('cash'));
        $this->addColumn('{{%orders}}', 'total', $this->decimal(10,2)->notNull()->defaultValue(0));

        // Create products table
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),
            'composition' => $this->text()->null(),
            'allergens' => $this->text()->null(),
            'nutrition' => $this->text()->null(),
            'price' => $this->decimal(10,2)->notNull(),
            'image' => $this->string(255)->null(),
            'rating' => $this->decimal(2,1)->defaultValue(0),
            'stock' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-products-category_id',
            '{{%products}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Create order_items table
        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-order_items-order_id',
            '{{%order_items}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-order_items-product_id',
            '{{%order_items}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // Drop new tables
        $this->dropForeignKey('fk-order_items-product_id', '{{%order_items}}');
        $this->dropForeignKey('fk-order_items-order_id', '{{%order_items}}');
        $this->dropTable('{{%order_items}}');

        $this->dropForeignKey('fk-products-category_id', '{{%products}}');
        $this->dropTable('{{%products}}');

        // Remove added columns from orders
        $this->dropColumn('{{%orders}}', 'total');
        $this->dropColumn('{{%orders}}', 'payment_method');
        $this->dropColumn('{{%orders}}', 'delivery_time');
        $this->dropColumn('{{%orders}}', 'delivery_address');
        $this->dropColumn('{{%orders}}', 'delivery_type');

        // Drop foreign key to allow truncate
        $this->dropForeignKey('fk-orders-category_id', '{{%orders}}');

        // Restore categories to old
        $this->execute('TRUNCATE TABLE {{%categories}}');
        $this->batchInsert('{{%categories}}', ['title'], [
            ['Химчистка обуви'],
            ['Химчистка верхней одежды'],
            ['Химчистка мягкой мебели'],
            ['Химчистка ковровых покрытий'],
        ]);

        // Add foreign key back
        $this->addForeignKey('fk-orders-category_id', '{{%orders}}', 'category_id', '{{%categories}}', 'id', 'CASCADE', 'CASCADE');
    }
}
