<?php

namespace app\modules\communal\assets;

use yii\web\AssetBundle;

class CommunalRequestAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/communal/assets';
    public $css = [
        'css/request.css',
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
