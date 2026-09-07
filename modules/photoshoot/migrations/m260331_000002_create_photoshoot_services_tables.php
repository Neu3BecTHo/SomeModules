<?php

use yii\db\Migration;

class m260331_000002_create_photoshoot_services_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%services}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(10, 2)->notNull(),
            'image' => $this->string(255),
            'is_active' => $this->integer()->defaultValue(1),
            'sort_order' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Insert default services
        $this->insert('{{%services}}', [
            'name' => 'Аренда малого зала 25 минут',
            'description' => 'Аренда фотозала с уютным интерьером для профессиональной съемки',
            'price' => 1200,
            'is_active' => 1,
            'sort_order' => 1,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Аренда малого зала 55 минут',
            'description' => 'Аренда фотозала с уютным интерьером для профессиональной съемки',
            'price' => 2000,
            'is_active' => 1,
            'sort_order' => 2,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Аренда малого зала 2 часа',
            'description' => 'Аренда фотозала с уютным интерьером для профессиональной съемки',
            'price' => 4000,
            'is_active' => 1,
            'sort_order' => 3,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Аренда малого зала 3 часа',
            'description' => 'Аренда фотозала с уютным интерьером для профессиональной съемки',
            'price' => 6000,
            'is_active' => 1,
            'sort_order' => 4,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Аренда большого зала 25 минут',
            'description' => 'Аренда просторного фотозала для профессиональной съемки',
            'price' => 1500,
            'is_active' => 1,
            'sort_order' => 5,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Аренда большого зала 55 минут',
            'description' => 'Аренда просторного фотозала для профессиональной съемки',
            'price' => 2500,
            'is_active' => 1,
            'sort_order' => 6,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Аренда большого зала 2 часа',
            'description' => 'Аренда просторного фотозала для профессиональной съемки',
            'price' => 5000,
            'is_active' => 1,
            'sort_order' => 7,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Аренда большого зала 3 часа',
            'description' => 'Аренда просторного фотозала для профессиональной съемки',
            'price' => 7500,
            'is_active' => 1,
            'sort_order' => 8,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Фотосессия в большом зале 25 минут',
            'description' => 'Профессиональная фотосъемка с фотографом студии',
            'price' => 6000,
            'is_active' => 1,
            'sort_order' => 9,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Фотосессия в большом зале 55 минут',
            'description' => 'Профессиональная фотосъемка с фотографом студии',
            'price' => 10000,
            'is_active' => 1,
            'sort_order' => 10,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Фотосессия в малом зале 25 минут',
            'description' => 'Профессиональная фотосъемка с фотографом студии',
            'price' => 6000,
            'is_active' => 1,
            'sort_order' => 11,
        ]);
        $this->insert('{{%services}}', [
            'name' => 'Фотосессия в малом зале 55 минут',
            'description' => 'Профессиональная фотосъемка с фотографом студии',
            'price' => 10000,
            'is_active' => 1,
            'sort_order' => 12,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%services}}');
    }
}
