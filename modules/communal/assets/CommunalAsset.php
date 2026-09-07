<?php

namespace app\modules\communal\assets;

use yii\web\AssetBundle;

class CommunalAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/communal/assets';
    public $css = [
        'css/common.css',
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
