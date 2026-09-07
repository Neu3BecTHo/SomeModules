<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Photo model
 *
 * @property int $id
 * @property int $master_id
 * @property string $image
 * @property string $title
 * @property string $description
 * @property int $sort_order
 * @property string $created_at
 */
class Photo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_photos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'image'], 'required'],
            [['master_id', 'sort_order'], 'integer'],
            [['description'], 'string'],
            [['image', 'title'], 'string', 'max' => 255],
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
            'master_id' => 'Мастер',
            'image' => 'Изображение',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'sort_order' => 'Порядок сортировки',
            'created_at' => 'Создан',
        ];
    }

    /**
     * Gets query for [[Master]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaster()
    {
        return $this->hasOne(Master::class, ['id' => 'master_id']);
    }
}
