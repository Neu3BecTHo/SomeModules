<?php

namespace app\modules\beauty\assets;

use yii\web\AssetBundle;

/**
 * ProfileAsset for beauty module
 */
class ProfileAsset extends AssetBundle
{
    public $sourcePath = __DIR__;
    
    public $css = [
        'css/beauty-profile.css',
    ];
    
    public $js = [
        'js/beauty-profile.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'app\modules\beauty\assets\BeautyAsset',
    ];
}
