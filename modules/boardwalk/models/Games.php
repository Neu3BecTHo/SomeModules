<?php

namespace app\modules\boardwalk\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "board_games".
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string|null $short_description
 * @property string|null $description
 * @property int|null $min_players
 * @property int|null $max_players
 * @property int|null $min_age
 * @property int|null $duration_minutes
 * @property int $is_popular
 * @property string|null $image
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property GameSessions[] $gameSessions
 */
class Games extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%games}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('boardwalk');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'short_description', 'description', 'min_players', 'max_players', 'min_age', 'duration_minutes', 'image'], 'default', 'value' => null],
            [['is_popular'], 'default', 'value' => 0],
            [['title'], 'required'],
            [['description'], 'string'],
            [['min_players', 'max_players', 'min_age', 'duration_minutes', 'is_popular'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'image'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 500],
            [['slug'], 'unique'],
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
            'slug' => Yii::t('app', 'Имя'),
            'short_description' => Yii::t('app', 'Короткое описание'),
            'description' => Yii::t('app', 'Длинное описание'),
            'min_players' => Yii::t('app', 'Минимальное количество игроков'),
            'max_players' => Yii::t('app', 'Максимальное количество игроков'),
            'min_age' => Yii::t('app', 'Минимальный возраст'),
            'duration_minutes' => Yii::t('app', 'Длительность в минутах'),
            'is_popular' => Yii::t('app', 'Популярен'),
            'image' => Yii::t('app', 'Изображение'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * Gets query for [[GameSessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGameSessions()
    {
        return $this->hasMany(GameSessions::class, ['game_id' => 'id']);
    }

}
