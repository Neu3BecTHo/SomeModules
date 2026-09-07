<?php

namespace app\modules\boardwalk\assets;

use yii\web\AssetBundle;

class BoardwalkMainAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/boardwalk/assets';
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
