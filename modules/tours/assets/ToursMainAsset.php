<?php

namespace app\modules\tours\assets;

use yii\web\AssetBundle;

class ToursMainAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/tours/assets';
    public $css = [
        'css/main.css',
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
