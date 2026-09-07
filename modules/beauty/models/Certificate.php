<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Certificate model
 *
 * @property int $id
 * @property int $master_id
 * @property string $title
 * @property string $image
 * @property string $issued_date
 * @property string $expiry_date
 * @property string $description
 * @property string $created_at
 */
class Certificate extends ActiveRecord
{
    /**
     * @var string|null
     */
    public $description;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_certificates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'title', 'image', 'issued_date'], 'required'],
            [['master_id'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['issued_date', 'expiry_date'], 'safe'],
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
            'title' => 'Название',
            'image' => 'Изображение',
            'issued_date' => 'Дата выдачи',
            'expiry_date' => 'Срок действия',
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
