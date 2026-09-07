<?php

namespace app\modules\common;

use Yii;
use yii\base\Module as BaseModule;

/**
 * Common module provides shared functionality for all service modules.
 * This eliminates code duplication across 8 admin modules.
 */
class Module extends BaseModule
{
    public $controllerNamespace = 'app\modules\common\controllers';

    public function init()
    {
        parent::init();
        // Shared components can be registered here
    }
}
