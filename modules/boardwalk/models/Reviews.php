<?php

namespace app\modules\boardwalk\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "board_reviews".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $author_name
 * @property string $text
 * @property int|null $rating
 * @property int $is_published
 * @property string|null $created_at
 *
 * @property User $user
 */
class Reviews extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reviews}}';
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
            [['user_id', 'rating'], 'default', 'value' => null],
            [['is_published'], 'default', 'value' => 0],
            [['user_id', 'rating', 'is_published'], 'integer'],
            [['author_name', 'text'], 'required'],
            [['text'], 'string'],
            [['created_at'], 'safe'],
            [['author_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Пользователь'),
            'author_name' => Yii::t('app', 'Автор'),
            'text' => Yii::t('app', 'Текст'),
            'rating' => Yii::t('app', 'Рейтинг'),
            'is_published' => Yii::t('app', 'Опубликован'),
            'created_at' => Yii::t('app', 'Создан'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
