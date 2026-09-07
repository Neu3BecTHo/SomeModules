<?php

namespace app\modules\photoshoot\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "photoshoot_gallery".
 *
 * @property int $id
 * @property string $title
 * @property string $category
 * @property string $image
 * @property string|null $description
 * @property int $is_active
 * @property int $sort_order
 * @property string|null $created_at
 */
class Gallery extends ActiveRecord
{
    const CATEGORY_PORTRAIT = 'portrait';
    const CATEGORY_FAMILY = 'family';
    const CATEGORY_WEDDING = 'wedding';
    const CATEGORY_CHILDREN = 'children';
    const CATEGORY_LOVE = 'love';
    const CATEGORY_BUSINESS = 'business';

    public static function getDb()
    {
        return Yii::$app->get('photoshoot');
    }

    public static function tableName()
    {
        return '{{%gallery}}';
    }

    public function rules()
    {
        return [
            [['title', 'category', 'image'], 'required'],
            [['is_active', 'sort_order'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'image'], 'string', 'max' => 255],
            [['category'], 'in', 'range' => [self::CATEGORY_PORTRAIT, self::CATEGORY_FAMILY, self::CATEGORY_WEDDING, self::CATEGORY_CHILDREN, self::CATEGORY_LOVE, self::CATEGORY_BUSINESS]],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'category' => 'Категория',
            'image' => 'Изображение',
            'description' => 'Описание',
            'is_active' => 'Активно',
            'sort_order' => 'Порядок сортировки',
            'created_at' => 'Создано',
        ];
    }

    public static function getCategoryLabels()
    {
        return [
            self::CATEGORY_PORTRAIT => 'Портреты',
            self::CATEGORY_FAMILY => 'Семейные',
            self::CATEGORY_WEDDING => 'Свадьбы',
            self::CATEGORY_CHILDREN => 'Детские',
            self::CATEGORY_LOVE => 'Love Story',
            self::CATEGORY_BUSINESS => 'Бизнес',
        ];
    }

    public function getCategoryLabel()
    {
        return self::getCategoryLabels()[$this->category] ?? $this->category;
    }
}
