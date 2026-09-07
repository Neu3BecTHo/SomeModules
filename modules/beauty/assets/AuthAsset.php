<?php

namespace app\modules\beauty\assets;

use yii\web\AssetBundle;

/**
 * AuthAsset for beauty module
 */
class AuthAsset extends AssetBundle
{
    public $sourcePath = __DIR__;
    
    public $css = [
        'css/beauty-auth.css',
    ];
    
    public $js = [
        'js/beauty-auth.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'app\modules\beauty\assets\BeautyAsset',
    ];
}
