<?php

use yii\db\Migration;

/**
 * Class m260331_000007_photoshoot_rbac_init
 */
class m260331_000007_photoshoot_rbac_init extends Migration
{
    public function safeUp()
    {
        $auth = \Yii::$app->authManager;
        
        // Получаем роль "Администратор" (создана через seed/init)
        $adminRole = $auth->getRole('Администратор');
        
        if ($adminRole) {
            // Находим пользователя FotoAdmin
            $userId = (new \yii\db\Query())
                ->select('id')
                ->from('{{%users}}')
                ->where(['login' => 'FotoAdmin'])
                ->scalar();
            
            if ($userId) {
                // Назначаем роль админа пользователю
                $auth->assign($adminRole, $userId);
                echo "Роль 'Администратор' назначена пользователю FotoAdmin (ID: {$userId})\n";
            }
        }
    }

    public function safeDown()
    {
        $auth = \Yii::$app->authManager;
        
        try {
            $userId = (new \yii\db\Query())
                ->select('id')
                ->from('{{%users}}')
                ->where(['login' => 'FotoAdmin'])
                ->scalar();
            
            if ($userId) {
                $auth->revokeAll($userId);
            }
        } catch (\yii\db\Exception $e) {
            // Таблица не существует, пропускаем
        }
    }
}
