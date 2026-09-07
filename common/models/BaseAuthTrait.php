<?php

namespace app\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * BaseAuthTrait - shared authentication logic for all module User models
 *
 * Usage: add `use BaseAuthTrait;` to any User model that implements IdentityInterface
 */
trait BaseAuthTrait
{
    /**
     * Validates password
     */
    public function validatePassword($password): bool
    {
        if (empty($this->password)) {
            return false;
        }
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Sets password hash
     */
    public function setPassword($password): void
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates auth key
     */
    public function generateAuthKey(): void
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Validates auth key
     */
    public function validateAuthKey($authKey): bool
    {
        if (empty($this->authKey)) {
            return false;
        }
        return hash_equals($this->authKey, $authKey);
    }

    /**
     * Generates access token
     */
    public function generateAccessToken(): void
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }

    /**
     * Finds user by access token
     */
    public static function findIdentityByAccessToken($token, $type = null): ?ActiveRecord
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by username or email
     */
    public static function findIdentityByLogin($login): ?ActiveRecord
    {
        return static::findOne(['email' => $login]) ?: static::findOne(['username' => $login]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): ?ActiveRecord
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }
}
