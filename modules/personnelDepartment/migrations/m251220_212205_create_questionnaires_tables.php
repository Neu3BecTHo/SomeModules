<?php

use yii\db\Migration;

class m251220_212205_create_questionnaires_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questionnaires}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),

            // Основные данные
            'birth_date' => $this->date()->null(),
            'gender' => $this->string(20)->null(),
            'citizenship' => $this->string(100)->null(),

            // Паспорт
            'passport_series' => $this->string(10)->null(),
            'passport_number' => $this->string(20)->null(),
            'passport_issued_by' => $this->string(255)->null(),
            'passport_issued_at' => $this->date()->null(),
            'registration_address' => $this->string(255)->null(),
            'marital_status' => $this->string(100)->null(),

            // Образование
            'education_level' => $this->string(50)->null(), // основное, среднее, СПО, высшее
            'education_org_name' => $this->string(255)->null(),
            'education_specialty' => $this->string(255)->null(),
            'education_diploma_series' => $this->string(50)->null(),
            'education_diploma_number' => $this->string(50)->null(),

            // СНИЛС (текст + файл отдельно)
            'snils_number' => $this->string(20)->null(),

            // Работа
            'workplace' => $this->string(255)->null(),
            'position' => $this->string(255)->null(),
            'experience_years' => $this->integer()->null(),
            'health_state' => $this->string(255)->null(),

            // Контакты (подставляются из регистрации, но храним здесь слепок)
            'phone' => $this->string(20)->null(),
            'email' => $this->string(255)->null(),

            'extra_info' => $this->text()->null(),

            // Статус анкеты
            'status_id' => $this->integer()->notNull(),

            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-pers_questionnaires-user_id',
            '{{%questionnaires}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-pers_questionnaires-status_id',
            '{{%questionnaires}}',
            'status_id',
            '{{%statuses}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pers_questionnaires-status_id', '{{%questionnaires}}');
        $this->dropForeignKey('fk-pers_questionnaires-user_id', '{{%questionnaires}}');
        $this->dropTable('{{%questionnaires}}');
    }
}
