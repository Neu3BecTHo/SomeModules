<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Master model
 *
 * @property int $id
 * @property int $user_id
 * @property string $specialization
 * @property string $bio
 * @property string $photo
 * @property string $rating
 * @property bool $is_approved
 * @property string $certificate_expiry
 * @property string $created_at
 * @property string $updated_at
 */
class Master extends ActiveRecord
{
    /**
     * @var \yii\web\UploadedFile|null
     */
    public $photoFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_masters}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'specialization'], 'required'],
            [['user_id'], 'integer'],
            [['bio'], 'string'],
            [['specialization', 'photo'], 'string', 'max' => 255],
            [['rating'], 'number', 'min' => 0, 'max' => 5],
            [['is_approved'], 'boolean'],
            [['is_approved'], 'default', 'value' => false],
            [['certificate_expiry'], 'safe'],
            [['photoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'specialization' => 'Специализация',
            'bio' => 'Биография',
            'photo' => 'Фото',
            'rating' => 'Рейтинг',
            'is_approved' => 'Подтвержден',
            'certificate_expiry' => 'Срок действия сертификата',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
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

    /**
     * Gets query for [[MasterServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterServices()
    {
        return $this->hasMany(MasterService::class, ['master_id' => 'id']);
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])
            ->viaTable('{{%beauty_master_services}}', ['master_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['master_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['master_id' => 'id']);
    }

    /**
     * Gets query for [[Schedules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasMany(Schedule::class, ['master_id' => 'id']);
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::class, ['master_id' => 'id']);
    }

    /**
     * Gets query for [[Certificates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificates()
    {
        return $this->hasMany(Certificate::class, ['master_id' => 'id']);
    }
}
