<?php

namespace app\modules\photoshoot\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "photoshoot_news".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $type
 * @property string|null $image
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class News extends ActiveRecord
{
    const TYPE_NEWS = 'news';
    const TYPE_PROMO = 'promo';

    public static function getDb()
    {
        return Yii::$app->get('photoshoot');
    }

    public static function tableName()
    {
        return '{{%news}}';
    }

    public function rules()
    {
        return [
            [['title', 'content', 'type'], 'required'],
            [['content'], 'string'],
            [['is_active'], 'integer'],
            [['date_start', 'date_end', 'created_at', 'updated_at'], 'safe'],
            [['title', 'image'], 'string', 'max' => 255],
            [['type'], 'in', 'range' => [self::TYPE_NEWS, self::TYPE_PROMO]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Содержание',
            'type' => 'Тип',
            'image' => 'Изображение',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'is_active' => 'Активно',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public static function getTypeLabels()
    {
        return [
            self::TYPE_NEWS => 'Новость',
            self::TYPE_PROMO => 'Акция',
        ];
    }

    public function getTypeLabel()
    {
        return self::getTypeLabels()[$this->type] ?? $this->type;
    }

    public function isActual()
    {
        $now = date('Y-m-d');
        if ($this->date_start && $this->date_start > $now) {
            return false;
        }
        if ($this->date_end && $this->date_end < $now) {
            return false;
        }
        return true;
    }
}
