<?php

namespace app\modules\communal\assets;

use yii\web\AssetBundle;

class CommunalMainAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/communal/assets';
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
