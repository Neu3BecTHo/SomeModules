<?php

use yii\db\Migration;

/**
 * Add product_id to reviews table
 */
class m260214_020000_add_product_id_to_reviews_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%reviews}}', 'product_id', $this->integer()->notNull());
        
        // Create index for product_id
        $this->createIndex('idx-reviews-product_id', '{{%reviews}}', 'product_id');
        
        // Add foreign key for product_id
        $this->addForeignKey(
            'fk-reviews-product_id',
            '{{%reviews}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-reviews-product_id', '{{%reviews}}');
        $this->dropIndex('idx-reviews-product_id', '{{%reviews}}');
        $this->dropColumn('{{%reviews}}', 'product_id');
    }
}
