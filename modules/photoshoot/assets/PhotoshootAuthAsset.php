<?php

namespace app\modules\photoshoot\assets;

use yii\web\AssetBundle;

class PhotoshootAuthAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/photoshoot/assets';
    public $css = [
        'css/auth.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
