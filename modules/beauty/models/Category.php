<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Category model
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property int $sort_order
 * @property bool $is_active
 */
class Category extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],
            [['sort_order'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'image' => 'Изображение',
            'sort_order' => 'Порядок сортировки',
            'is_active' => 'Активна',
        ];
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::class, ['category_id' => 'id']);
    }
}
