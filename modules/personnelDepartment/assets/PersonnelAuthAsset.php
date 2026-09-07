<?php

namespace app\modules\personnelDepartment\assets;

use yii\web\AssetBundle;

class PersonnelAuthAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/personnelDepartment/assets';
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
