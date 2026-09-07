<?php

namespace app\modules\common\controllers;

use Yii;
use yii\web\Controller;

/**
 * AdminControllerBase is the shared base controller for all admin modules.
 * All 8 admin modules (tours, beauty, boardwalk, breadHouse, cleaner, communal,
 * personnelDepartment, photoshoot) should extend this instead of yii\web\Controller.
 *
 * Usage:
 *   class RequestsController extends AdminControllerBase { ... }
 *
 * This provides:
 * - Unified admin authentication check
 * - Common layout registration
 * - Standardized error responses
 */
class AdminControllerBase extends Controller
{
    /**
     * @var string The asset class to register for the admin panel.
     * Each module should set this: e.g., ToursAdminAsset, BeautyAdminAsset
     */
    public $assetClass = null;

    /**
     * @var string The module name for flash messages (e.g., 'tours', 'beauty')
     * Each module should set this in init().
     */
    public $modulePrefix = '';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Admin authentication - must be logged in and have admin role
        $user = Yii::$app->user;
        
        // Try to use the module-specific user component, fallback to 'user'
        $userComponent = $this->getUserComponentName();
        
        if (!isset(Yii::$app->{$userComponent})) {
            Yii::$app->response->redirect(['/main/index']);
            return false;
        }
        
        $user = Yii::$app->{$userComponent};
        
        if ($user->isGuest) {
            Yii::$app->session->setFlash('error', 'Необходимо авторизоваться');
            return Yii::$app->response->redirect(['/main/index']);
        }

        // Register admin asset if specified
        if ($this->assetClass) {
            $this->assetClass::register($this->view);
        }

        return true;
    }

    /**
     * Get the user component name for the current module.
     * This is determined by convention: e.g., 'userTours' for tours module.
     */
    protected function getUserComponentName(): string
    {
        // Get controller id to determine module
        $controllerId = Yii::$app->controller->id;
        
        // Map controller namespace to user component
        // Common patterns: userTours, userBeauty, userBoardwalk, etc.
        $moduleMap = [
            'admin-tours' => 'userTours',
            'admin-beauty' => 'userBeauty', 
            'admin-boardwalk' => 'userBoardwalk',
            'admin-bread-house' => 'userBreadHouse',
            'admin-cleaner' => 'userCleaner',
            'admin-communal' => 'userCommunal',
            'admin-personnel-department' => 'userPersonnelDepartment',
            'admin-photoshoot' => 'userPhotoshoot',
        ];

        // Try to find a matching user component from the namespace
        $namespace = Yii::$app->controller->getModuleName();
        $namespace = str_replace('-', '', ucwords($namespace, '-'));
        
        // Build user component name from module
        $userComponent = 'user' . $namespace;
        
        return Yii::$app->has($userComponent) ? $userComponent : 'user';
    }

    /**
     * Standardized flash message helper
     */
    protected function setFlashMessage($type, $message): void
    {
        $prefix = $this->modulePrefix ? $this->modulePrefix . '.' : '';
        Yii::$app->session->setFlash($prefix . $type, $message);
    }

    /**
     * Standardized redirect with flash message
     */
    protected function redirectWithFlash($url, $type, $message): \yii\web\Response
    {
        $this->setFlashMessage($type, $message);
        return $this->redirect($url);
    }

    /**
     * Handle AJAX response
     */
    protected function asJsonResponse($success, $message = '', $data = []): void
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = ['success' => $success];
        if ($message) {
            $response['message'] = $message;
        }
        if ($data) {
            $response['data'] = $data;
        }
        echo json_encode($response);
        Yii::$app->end();
    }
}
