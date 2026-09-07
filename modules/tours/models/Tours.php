<?php

namespace app\modules\tours\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tour_tours".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property float $price
 * @property string|null $image
 * @property int $duration_days
 * @property int $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Requests[] $requests
 * @property Reviews[] $reviews
 */
class Tours extends ActiveRecord
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tours}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('tours');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'default', 'value' => null],
            [['is_active'], 'default', 'value' => 1],
            [['title', 'slug', 'short_description', 'description', 'price'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['duration_days', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 150],
            [['short_description', 'image'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            ['imageFile', 'image',
                'extensions' => 'png, jpg, jpeg, webp',
                'maxSize' => 2 * 1024 * 1024,
                'skipOnEmpty' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Заголовок'),
            'slug' => Yii::t('app', 'Место'),
            'short_description' => Yii::t('app', 'Короткое описание'),
            'description' => Yii::t('app', 'Полное описание'),
            'price' => Yii::t('app', 'Стоимость'),
            'image' => Yii::t('app', 'Изображение'),
            'duration_days' => Yii::t('app', 'Длительность'),
            'is_active' => Yii::t('app', 'Активен'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    public function uploadAndSave(): bool
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if (!$this->validate()) {
            return false;
        }

        if ($this->imageFile) {
            $fileName = 'tour_' . time() . '_' . mt_rand(1000, 9999) . '.' . $this->imageFile->extension;
            $path = Yii::getAlias('@webroot/uploads/tours/' . $fileName);

            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0775, true);
            }

            if ($this->imageFile->saveAs($path)) {
                $this->image = '/uploads/tours/' . $fileName;
            }
        }

        return $this->save(false);
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Requests::class, ['tour_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['tour_id' => 'id']);
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord && empty($this->slug) && !empty($this->title)) {
                $this->slug = Inflector::slug($this->title) . '-' . uniqid();
            }
            return true;
        }
        return false;
    }
}
