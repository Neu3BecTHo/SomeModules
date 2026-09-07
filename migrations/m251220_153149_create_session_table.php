<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%session}}`.
 */
class m251220_153149_create_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%session}}', [
            'id' => $this->char(40)->notNull(),
            'expire' => $this->integer()->notNull(),
            'data' => $this->binary(),
            'PRIMARY KEY([[id]])',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%session}}');
    }
}
