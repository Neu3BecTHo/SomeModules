<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%beauty_users}}`.
 */
class m260318_064000_beauty_salon extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Create users table
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(20)->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'full_name' => $this->string()->notNull(),
            'role' => $this->string(20)->notNull()->defaultValue('client'), // client, master, admin
            'is_active' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create masters table
        $this->createTable('{{%masters}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'specialization' => $this->string()->notNull(),
            'bio' => $this->text(),
            'photo' => $this->string(),
            'rating' => $this->decimal(3, 2)->defaultValue(0),
            'is_approved' => $this->boolean()->defaultValue(false),
            'certificate_expiry' => $this->date(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create categories table
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'image' => $this->string(),
            'sort_order' => $this->integer()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(true),
        ]);

        // Create services table
        $this->createTable('{{%services}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'duration' => $this->integer()->notNull(), // in minutes
            'price' => $this->decimal(10, 2)->notNull(),
            'image' => $this->string(),
            'is_active' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create master_services table (many-to-many)
        $this->createTable('{{%master_services}}', [
            'id' => $this->primaryKey(),
            'master_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
        ]);

        // Create schedules table
        $this->createTable('{{%schedules}}', [
            'id' => $this->primaryKey(),
            'master_id' => $this->integer()->notNull(),
            'day_of_week' => $this->integer()->notNull(), // 1-7 (Monday-Sunday)
            'start_time' => $this->time()->notNull(),
            'end_time' => $this->time()->notNull(),
            'is_available' => $this->boolean()->defaultValue(true),
        ]);

        // Create orders table
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'master_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'appointment_date' => $this->date()->notNull(),
            'appointment_time' => $this->time()->notNull(),
            'status' => $this->string(20)->defaultValue('new'), // new, confirmed, in_progress, completed, cancelled
            'payment_method' => $this->string(20)->notNull(), // cash, card
            'total_price' => $this->decimal(10, 2)->notNull(),
            'notes' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create reviews table
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'master_id' => $this->integer()->notNull(),
            'rating' => $this->integer()->notNull(), // 1-5
            'comment' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create certificates table
        $this->createTable('{{%certificates}}', [
            'id' => $this->primaryKey(),
            'master_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'issued_date' => $this->date()->notNull(),
            'expiry_date' => $this->date(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create photos table (for masters' work gallery)
        $this->createTable('{{%photos}}', [
            'id' => $this->primaryKey(),
            'master_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
            'sort_order' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create indexes
        $this->createIndex('idx-beauty-users-phone', '{{%users}}', 'phone');
        $this->createIndex('idx-beauty-masters-user_id', '{{%masters}}', 'user_id');
        $this->createIndex('idx-beauty-services-category_id', '{{%services}}', 'category_id');
        $this->createIndex('idx-beauty-master_services-master_id', '{{%master_services}}', 'master_id');
        $this->createIndex('idx-beauty-master_services-service_id', '{{%master_services}}', 'service_id');
        $this->createIndex('idx-beauty-schedules-master_id', '{{%schedules}}', 'master_id');
        $this->createIndex('idx-beauty-orders-client_id', '{{%orders}}', 'client_id');
        $this->createIndex('idx-beauty-orders-master_id', '{{%orders}}', 'master_id');
        $this->createIndex('idx-beauty-orders-service_id', '{{%orders}}', 'service_id');
        $this->createIndex('idx-beauty-reviews-order_id', '{{%reviews}}', 'order_id');
        $this->createIndex('idx-beauty-certificates-master_id', '{{%certificates}}', 'master_id');
        $this->createIndex('idx-beauty-photos-master_id', '{{%photos}}', 'master_id');

        // Create foreign keys
        $this->addForeignKey('fk-beauty-masters-user_id', '{{%masters}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-services-category_id', '{{%services}}', 'category_id', '{{%categories}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-master_services-master_id', '{{%master_services}}', 'master_id', '{{%masters}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-master_services-service_id', '{{%master_services}}', 'service_id', '{{%services}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-schedules-master_id', '{{%schedules}}', 'master_id', '{{%masters}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-orders-client_id', '{{%orders}}', 'client_id', '{{%users}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-orders-master_id', '{{%orders}}', 'master_id', '{{%masters}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-orders-service_id', '{{%orders}}', 'service_id', '{{%services}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-reviews-order_id', '{{%reviews}}', 'order_id', '{{%orders}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-reviews-client_id', '{{%reviews}}', 'client_id', '{{%users}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-reviews-master_id', '{{%reviews}}', 'master_id', '{{%masters}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-certificates-master_id', '{{%certificates}}', 'master_id', '{{%masters}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-beauty-photos-master_id', '{{%photos}}', 'master_id', '{{%masters}}', 'id', 'CASCADE');

        // Insert default admin user
        $this->insert('{{%users}}', [
            'phone' => '+7(123)456-78-90',
            'password_hash' => Yii::$app->security->generatePasswordHash('beauty123'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'full_name' => 'Главный Администратор',
            'role' => 'admin',
            'is_active' => true,
        ]);
        
        // Get correct database connection for beauty module
        $db = Yii::$app->get('beauty');
        
        // Get inserted user ID and assign admin role
        $userId = $db->getLastInsertID();
        
        // Create admin role if it doesn't exist
        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');
        if ($adminRole === null) {
            $adminRole = $auth->createRole('admin');
            $auth->add($adminRole);
        }
        
        $auth->assign($adminRole, $userId);

        // Insert sample categories
        $this->insert('{{%categories}}', ['name' => 'Парикмахерские услуги', 'description' => 'Стрижки, укладки, окрашивание волос', 'sort_order' => 1]);
        $this->insert('{{%categories}}', ['name' => 'Ногтевой сервис', 'description' => 'Маникюр, педикюр, наращивание ногтей', 'sort_order' => 2]);
        $this->insert('{{%categories}}', ['name' => 'Косметология', 'description' => 'Уход за лицом, чистки, маски', 'sort_order' => 3]);
        $this->insert('{{%categories}}', ['name' => 'Массаж', 'description' => 'Расслабляющий, лечебный, спортивный массаж', 'sort_order' => 4]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys
        $this->dropForeignKey('fk-beauty-photos-master_id', '{{%photos}}');
        $this->dropForeignKey('fk-beauty-certificates-master_id', '{{%certificates}}');
        $this->dropForeignKey('fk-beauty-reviews-master_id', '{{%reviews}}');
        $this->dropForeignKey('fk-beauty-reviews-client_id', '{{%reviews}}');
        $this->dropForeignKey('fk-beauty-reviews-order_id', '{{%reviews}}');
        $this->dropForeignKey('fk-beauty-orders-service_id', '{{%orders}}');
        $this->dropForeignKey('fk-beauty-orders-master_id', '{{%orders}}');
        $this->dropForeignKey('fk-beauty-orders-client_id', '{{%orders}}');
        $this->dropForeignKey('fk-beauty-schedules-master_id', '{{%schedules}}');
        $this->dropForeignKey('fk-beauty-master_services-service_id', '{{%master_services}}');
        $this->dropForeignKey('fk-beauty-master_services-master_id', '{{%master_services}}');
        $this->dropForeignKey('fk-beauty-services-category_id', '{{%services}}');
        $this->dropForeignKey('fk-beauty-masters-user_id', '{{%masters}}');

        // Drop tables
        $this->dropTable('{{%photos}}');
        $this->dropTable('{{%certificates}}');
        $this->dropTable('{{%reviews}}');
        $this->dropTable('{{%orders}}');
        $this->dropTable('{{%schedules}}');
        $this->dropTable('{{%master_services}}');
        $this->dropTable('{{%services}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%masters}}');
        $this->dropTable('{{%users}}');
    }
}
