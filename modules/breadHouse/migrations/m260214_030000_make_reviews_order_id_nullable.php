<?php

use yii\db\Migration;

/**
 * Make order_id nullable in reviews table
 */
class m260214_030000_make_reviews_order_id_nullable extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%reviews}}', 'order_id', $this->integer()->null());
    }

    public function safeDown()
    {
        $this->alterColumn('{{%reviews}}', 'order_id', $this->integer()->notNull());
    }
}
