<?php

use yii\db\Migration;

class m251220_174521_create_service_types_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_types}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'code' => $this->string(50)->notNull()->unique(),
            'tariff' => $this->decimal(10, 2)->notNull(), 
            'unit' => $this->string(20)->notNull(),
        ]);

        // Данные по ТЗ
        $this->batchInsert('{{%service_types}}', ['title', 'code', 'tariff', 'unit'], [
            ['Электричество', 'electricity', 5.03, 'кВт·ч'],
            ['Газ', 'gas', 7.39, 'м³'],
            ['Вода', 'water', 48.24, 'м³'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_types}}');
    }
}
