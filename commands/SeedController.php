<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\modules\boardwalk\models\Games;
use app\modules\boardwalk\models\GameSessions;
use app\modules\boardwalk\models\User as UserBoardwalk;
use app\modules\communal\models\User;
use app\modules\personnelDepartment\models\User as UserPersonnel;
use app\modules\tours\models\User as UserTours;
use app\modules\cleaner\models\User as UserCleaner;
use Exception;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{
public function actionInit()
    {
        $authManager = Yii::$app->authManager;

        if ($authManager->getRoles()) {
            $authManager->removeAll();
            Console::output('Роли удалены.');
        }

        try {
            $user = $authManager->createRole('user');
            Console::output('Роль "Пользователь" создана.');
            $user->description = 'Пользователь с базовыми правами.';

            $admin = $authManager->createRole('admin');
            Console::output('Роль "Администратор" создана.');
            $admin->description = 'Администратор с правами на все.';

            $authManager->add($user);
            $authManager->add($admin);

            $authManager->addChild($admin, $user);

            Console::output('Роли созданы.');
        } catch (Exception $e) {
            Console::error('Ошибка при создании ролей: ' . $e->getMessage());
        }
    }

    public function actionCreateAdminCommunal()
    {
        // Ищем не по username 'admin', а по телефону из ТЗ, так надежнее
        $phone = '8(000)000-00-00';
        $user = User::findOne(['phone' => $phone]);

        if (!$user) {
            $user = new User();            
            $user->password = 'kommunalshik';
            
            $user->email = 'admin@portal.zhkh';
            $user->phone = $phone;

            $user->firstName = 'Администратор';
            $user->lastName = 'Главный';
            $user->patronymic = 'Системный';
            
            $user->address = 'Серверная, 1';
            $user->residents_count = 1;
            
            // Флаг админа (если есть колонка rules)
            if ($user->hasAttribute('rules')) {
                $user->rules = 1; 
            }

            if ($user->save()) {
                try {
                    $authManager = Yii::$app->authManager;
                    if ($authManager) {
                        $adminRole = $authManager->getRole('admin');
                        if ($adminRole) {
                            $authManager->assign($adminRole, $user->id);
                            Console::output('RBAC роль "admin" назначена.');
                        } else {
                             Console::output('RBAC роль "admin" не найдена, но пользователь создан.');
                        }
                    }
                } catch (Exception $e) {
                    Console::output('Ошибка RBAC: ' . $e->getMessage());
                }

                Console::output('Администратор создан успешно.');
                Console::output('Телефон: ' . $user->phone);
                Console::output('Пароль: kommunalshik');
            } else {
                // Вывод ошибок валидации
                $errorMessages = [];
                foreach ($user->errors as $field => $errors) {
                    $errorMessages = array_merge($errorMessages, $errors);
                }
                Console::error('Ошибка создания: ' . implode(', ', $errorMessages));
            }
        } else {
            Console::output('Администратор с телефоном ' . $phone . ' уже существует.');
        }
    }

    public function actionCreateAdminPersonnel()
    {
        $email = 'admin@mail.ru';

        $user = UserPersonnel::findOne(['email' => $email]);
        if ($user) {
            $this->stdout("Пользователь {$email} уже существует (ID: {$user->id}).\n");
            return ExitCode::OK;
        }

        $user = new UserPersonnel();
        $user->first_name = 'Администратор';
        $user->last_name = 'Отдела кадров';
        $user->patronymic = 'wewewweew';
        $user->phone = '+7(000)000-00-00';
        $user->email = $email;
        $user->rules = 1;

        $user->password = 'adminka';

        if ($user->save(false)) {
            $this->stdout("Администратор {$email} создан. Пароль: adminka\n");
            return ExitCode::OK;
        }

        $authManager = Yii::$app->authManager;
        $adminRole = $authManager->getRole('admin');
        if ($adminRole) {
            $authManager->assign($adminRole, $user->id);
        }

        $this->stderr("Не удалось создать администратора.\n");
        foreach ($user->getFirstErrors() as $attr => $error) {
            $this->stderr("$attr: $error\n");
        }

        return ExitCode::UNSPECIFIED_ERROR;
    }

    public function actionCreateAdminTour()
    {
        $email = 'admintour@mail.ru';

        /** @var UserTours|null $user */
        $user = UserTours::findOne(['email' => $email]);
        if ($user) {
            $this->stdout("Администратор туров {$email} уже существует (ID: {$user->id}).\n");
            return ExitCode::OK;
        }

        $user = new UserTours();
        $user->first_name = 'Администратор';
        $user->last_name = 'Отдела туров';
        $user->patronymic = 'wewewweew';
        $user->password = 'admintour';
        $user->phone = '+7(000)000-00-00';
        $user->email = $email;
        $user->passport_series = '0000';
        $user->passport_number = '000000';
        $user->address = 'Офис туров, 1';

        if (!$user->save()) {
            $errors = [];
            foreach ($user->errors as $attr => $errs) {
                $errors = array_merge($errors, $errs);
            }
            $this->stderr("Не удалось создать администратора туров: " . implode(', ', $errors) . "\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        // RBAC-роль admin (общая)
        $authManager = Yii::$app->authManager;
        if ($authManager) {
            $adminRole = $authManager->getRole('admin');
            if ($adminRole) {
                $authManager->assign($adminRole, $user->id);
                $this->stdout("RBAC роль 'admin' назначена пользователю туров.\n");
            } else {
                $this->stdout("RBAC роль 'admin' не найдена, но пользователь туров создан.\n");
            }
        }

        $this->stdout("Администратор туров создан.\n");
        $this->stdout("Email: {$user->email}\n");
        $this->stdout("Пароль: admintour\n");

        return ExitCode::OK;
    }

    public function actionCreateAdminBoardwalk()
    {
        $email = 'admin@nastolka.ru';
        $phone = '8(999)999-99-99';
        
        $user = UserBoardwalk::findOne(['email' => $email]);

        if ($user) {
            $this->stdout("Администратор настолок {$email} уже существует (ID: {$user->id}).\n", Console::FG_YELLOW);
            return ExitCode::OK;
        }

        $user = new UserBoardwalk();
        $user->first_name = 'Администратор';
        $user->last_name = 'Отдела туров';
        $user->patronymic = 'wewewweew';
        $user->phone = $phone;
        $user->email = $email;
        
        $user->password_hash = 'organizator';
        $user->status = 10;

        if ($user->save()) {
            $this->stdout("Пользователь создан успешно.\n", Console::FG_GREEN);
            
            // Назначаем RBAC роль admin
            $authManager = Yii::$app->authManager;
            if ($authManager) {
                $adminRole = $authManager->getRole('admin');
                if ($adminRole) {
                    try {
                        $authManager->assign($adminRole, $user->id);
                        $this->stdout("RBAC роль 'admin' успешно назначена.\n", Console::FG_GREEN);
                    } catch (Exception $e) {
                        $this->stderr("Ошибка при назначении роли: " . $e->getMessage() . "\n");
                    }
                } else {
                    $this->stdout("Предупреждение: роль 'admin' не найдена в системе. Сначала выполните php yii seed/init\n", Console::FG_YELLOW);
                }
            }

            $this->stdout("Данные для входа:\n", Console::BOLD);
            $this->stdout("Email: {$email}\n");
            $this->stdout("Телефон: {$phone}\n");
            $this->stdout("Пароль: organizator\n");
            
            return ExitCode::OK;
        }

        // Вывод ошибок, если валидация не прошла
        $this->stderr("Не удалось создать администратора настолок:\n", Console::FG_RED);
        foreach ($user->errors as $attribute => $messages) {
            foreach ($messages as $message) {
                $this->stderr("- $attribute: $message\n");
            }
        }

        return ExitCode::UNSPECIFIED_ERROR;
    }

    public function actionSeedSessions()
    {
        $games = Games::find()->all();
        
        if (empty($games)) {
            $this->stderr("Сначала добавьте игры в таблицу 'games'!\n");
            return;
        }

        foreach ($games as $index => $game) {
            $session = new GameSessions();
            $session->game_id = $game->id;
            
            // Генерируем даты: сегодня + несколько дней
            $session->start_at = date('Y-m-d H:i:s', strtotime('+' . ($index + 1) * 2 . ' days 18:00:00'));
            
            $session->seats_total = 6;
            $session->seats_taken = rand(0, 6);
            $session->end_at = date('Y-m-d H:i:s', strtotime('+' . ($index + 1) * 2 . ' days 20:00:00'));
            $session->status = 'planned';
            $session->address = 'ул. Настольная, 42';
            $session->price = 350;

            if ($session->save()) {
                $this->stdout("Создана сессия для игры: {$game->title} на {$session->start_at}\n");
            }
        }
    }

    public function actionSeedGames()
    {
        $games = [
            [
                'title' => 'Шакал',
                'category' => 'Стратегии',
                'short_description' => 'Пиратские приключения на острове сокровищ.',
                'min_players' => 2, 'max_players' => 4,
                'is_popular' => 1
            ],
            [
                'title' => 'Монополия',
                'category' => 'Экономические',
                'short_description' => 'Классическая игра о бизнесе и недвижимости.',
                'min_players' => 2, 'max_players' => 6,
                'is_popular' => 0
            ],
            [
                'title' => 'Взрывные котята',
                'category' => 'Карточные',
                'short_description' => 'Веселая и быстрая игра на выживание.',
                'min_players' => 2, 'max_players' => 5,
                'is_popular' => 1
            ],
            [
                'title' => 'Кубопрыги',
                'category' => 'Для детей',
                'short_description' => 'Активная игра для самых маленьких.',
                'min_players' => 2, 'max_players' => 8,
                'is_popular' => 0
            ],
        ];

        foreach ($games as $data) {
            $game = new Games();
            $game->attributes = $data;
            $game->category = $data['category'];
            if ($game->save()) {
                echo "Игра '{$game->title}' добавлена.\n";
            }
        }
    }

    public function actionCreateAdminCleaner()
    {
        $phone = '+8(999)999-99-99';
        $passwordPlain = 'himchistka';

        // Ищем по телефону
        $user = UserCleaner::findOne(['phone' => $phone]);

        if ($user) {
            $user->delete();
        }

        $user = new UserCleaner();
        $user->first_name = 'Администратор';
        $user->last_name = 'Химчистки';
        $user->patronymic = 'Системный';
        $user->phone = $phone;

        $user->password = 'himchistka';
        $user->is_admin = 1;

        if ($user->save()) {
            $authManager = Yii::$app->authManager;
            if ($authManager) {
                $adminRole = $authManager->getRole('admin');
                if ($adminRole) {
                    try {
                        $authManager->assign($adminRole, $user->id);
                        $this->stdout("RBAC роль 'admin' успешно назначена.\n", Console::FG_GREEN);
                    } catch (Exception $e) {
                        $this->stderr("Ошибка при назначении роли: " . $e->getMessage() . "\n");
                    }
                } else {
                    $this->stdout("Предупреждение: роль 'admin' не найдена в системе. Сначала выполните php yii seed/init\n", Console::FG_YELLOW);
                }
            }
            $this->stdout("Администратор химчистки создан успешно.\n", Console::FG_GREEN);
            $this->stdout("Данные для входа:\n", Console::BOLD);
            $this->stdout("Телефон: {$phone}\n");
            $this->stdout("Пароль: {$passwordPlain}\n");
            return ExitCode::OK;
        }

        $this->stderr("Не удалось создать администратора химчистки:\n", Console::FG_RED);
        foreach ($user->errors as $attribute => $messages) {
            foreach ($messages as $message) {
                $this->stderr("- $attribute: $message\n");
            }
        }
    }

    public function actionCreateAdminBreadHouse()
    {
        $phone = '+7(800)555-53-53';
        $passwordPlain = 'admin123';

        // Ищем по телефону
        $user = \app\modules\breadHouse\models\User::findOne(['phone' => $phone]);

        if ($user) {
            $user->delete();
        }

        $user = new \app\modules\breadHouse\models\User();
        $user->first_name = 'Администратор';
        $user->last_name = 'Хлебного';
        $user->patronymic = 'Системный';
        $user->phone = $phone;
        $user->email = 'admin@breadhouse.local';
        $user->password = $passwordPlain;
        $user->is_admin = 1;

        if ($user->save()) {
            $authManager = Yii::$app->authManager;
            if ($authManager) {
                $adminRole = $authManager->getRole('admin');
                if ($adminRole) {
                    try {
                        $authManager->assign($adminRole, $user->id);
                        $this->stdout("RBAC роль 'admin' успешно назначена.\n", Console::FG_GREEN);
                    } catch (Exception $e) {
                        $this->stderr("Ошибка при назначении роли: " . $e->getMessage() . "\n");
                    }
                } else {
                    $this->stdout("Предупреждение: роль 'admin' не найдена в системе. Сначала выполните php yii seed/init\n", Console::FG_YELLOW);
                }
            }
            $this->stdout("Администратор хлебного домика создан успешно.\n", Console::FG_GREEN);
            $this->stdout("Данные для входа:\n", Console::BOLD);
            $this->stdout("Телефон: {$phone}\n");
            $this->stdout("Пароль: {$passwordPlain}\n");
        } else {
            $this->stderr("Ошибка при создании администратора:\n", Console::FG_RED);
            foreach ($user->errors as $field => $errors) {
                foreach ($errors as $error) {
                    $this->stderr("  {$field}: {$error}\n");
                }
            }
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }
}