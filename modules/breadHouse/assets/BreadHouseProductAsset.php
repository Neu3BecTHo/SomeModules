<?php

namespace app\modules\breadHouse\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the breadHouse product pages
 */
class BreadHouseProductAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/breadHouse/assets';

    public $css = [
        'css/breadhouse-new.css',
    ];

    public $js = [
        // 'js/product.js',
    ];

    public $depends = [
        'app\modules\breadHouse\assets\BreadHouseLayoutAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
    
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
