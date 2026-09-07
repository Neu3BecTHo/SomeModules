<?php

namespace app\modules\photoshoot;

/**
 * photoshoot module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\photoshoot\controllers';
    public $layout = 'main';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $uploadPath = \Yii::getAlias('@webroot/uploads/photoshoot');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
    }
}
