<?php

use yii\db\Migration;

/**
 * Create product_images table for multiple images
 */
class m260214_010000_create_product_images_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_images}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'image' => $this->string(255)->notNull(),
            'sort_order' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-product_images-product_id',
            '{{%product_images}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-product_images-sort_order', '{{%product_images}}', ['product_id', 'sort_order']);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product_images-product_id', '{{%product_images}}');
        $this->dropTable('{{%product_images}}');
    }
}
