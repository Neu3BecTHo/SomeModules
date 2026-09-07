<?php

namespace app\modules\beauty\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class BeautyAsset extends AssetBundle
{
    public $sourcePath = __DIR__;
    
    public $css = [
        'css/beauty-main.css',
    ];
    
    public $js = [
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
