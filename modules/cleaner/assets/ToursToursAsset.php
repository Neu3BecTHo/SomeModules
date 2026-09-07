<?php

namespace app\modules\tours\assets;

use yii\web\AssetBundle;

class ToursToursAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/tours/assets';
    public $css = [
        'css/tours.css',
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
