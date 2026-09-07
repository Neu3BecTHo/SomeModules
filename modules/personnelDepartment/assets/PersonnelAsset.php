<?php

namespace app\modules\personnelDepartment\assets;

use yii\web\AssetBundle;

class PersonnelAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/personnelDepartment/assets';
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
