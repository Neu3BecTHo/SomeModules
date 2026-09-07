<?php

namespace app\modules\breadHouse\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for breadHouse layout styles
 */
class BreadHouseLayoutAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/breadHouse/assets';

    public $css = [
        'css/breadhouse-new.css',
    ];

    public $js = [
        // Layout specific JS if needed
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
    
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
