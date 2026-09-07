<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Service model
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property int $duration
 * @property string $price
 * @property string $image
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class Service extends ActiveRecord
{
    /**
     * @var UploadedFile|null
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_services}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'duration', 'price'], 'required'],
            [['category_id', 'duration'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number', 'min' => 0],
            [['name', 'image'], 'string', 'max' => 255],
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'name' => 'Название',
            'description' => 'Описание',
            'duration' => 'Длительность (мин)',
            'price' => 'Цена',
            'image' => 'Изображение',
            'is_active' => 'Активна',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[MasterServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterServices()
    {
        return $this->hasMany(MasterService::class, ['service_id' => 'id']);
    }

    /**
     * Gets query for [[Masters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasters()
    {
        return $this->hasMany(Master::class, ['id' => 'master_id'])
            ->viaTable('{{%beauty_master_services}}', ['service_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['service_id' => 'id']);
    }
}
