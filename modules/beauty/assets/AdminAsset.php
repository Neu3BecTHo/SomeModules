<?php

namespace app\modules\beauty\assets;

use yii\web\AssetBundle;

/**
 * AdminAsset for beauty module
 */
class AdminAsset extends AssetBundle
{
    public $sourcePath = __DIR__;
    
    public $css = [
        'css/beauty-admin.css',
    ];
    
    public $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'app\modules\beauty\assets\BeautyAsset',
    ];
}
