<?php

namespace app\modules\personnelDepartment\assets;

use yii\web\AssetBundle;

class PersonnelQuestionnairesAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/personnelDepartment/assets';
    public $css = [
        'css/questionnaires.css',
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
