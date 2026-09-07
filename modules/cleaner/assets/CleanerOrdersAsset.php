<?php

namespace app\modules\cleaner\assets;

use yii\web\AssetBundle;

class CleanerOrdersAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/cleaner/assets';
    public $css = [
        'css/orders.css',
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
