<?php

use yii\db\Migration;

class m251220_212356_create_files_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%files}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer()->notNull(),
            'type' => $this->string(50)->notNull(),
            'file_path' => $this->string(255)->notNull(),
            'file_name' => $this->string(255)->null(),
            'mime_type' => $this->string(100)->null(),
            'size' => $this->integer()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-pers_files-profile_id',
            '{{%files}}',
            'profile_id',
            '{{%questionnaires}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-pers_files-profile_id_type',
            '{{%files}}',
            ['profile_id', 'type']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-pers_files-profile_id_type', '{{%files}}');
        $this->dropForeignKey('fk-pers_questionnaires-profile_id', '{{%files}}');
        $this->dropTable('{{%files}}');
    }
}
