<?php

namespace app\modules\photoshoot\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "photoshoot_services".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $image
 * @property int $is_active
 * @property int $sort_order
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Service extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('photoshoot');
    }

    public static function tableName()
    {
        return '{{%services}}';
    }

    public function rules()
    {
        return [
            [['name', 'description', 'price'], 'required'],
            [['price'], 'number'],
            [['is_active', 'sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'image'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
            'image' => 'Изображение',
            'is_active' => 'Активна',
            'sort_order' => 'Порядок сортировки',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }
}
