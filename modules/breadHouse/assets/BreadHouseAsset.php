<?php

namespace app\modules\breadHouse\assets;

use yii\web\AssetBundle;

class BreadHouseAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/breadHouse/assets';
    public $css = [
        'css/breadhouse-new.css',
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
