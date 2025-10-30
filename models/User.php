<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users'; // نام جدول در دیتابیس
    }

    public function rules()
{
    return [
        // فیلدهای ضروری
        [['username', 'email'], 'required'],
        
        // نوع و محدودیت‌ها
        ['username', 'string', 'max' => 50],
        ['email', 'email'],
        ['email', 'string', 'max' => 100],
        
        // فیلدهای safe (برای password, status, etc.)
        [['password_hash', 'auth_key','username','email','created_at'], 'safe'],
        
        // یا به جای safe، هر کدوم رو جدا تعریف کن
        // ['password', 'string', 'min' => 6],
    ];
}

    public function fields()
    {
        return ['id', 'username', 'created_at', 'email'];
    }

    /**
     * Finds user by ID
     * @param string/int $id
     * @return static|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds user by access token
     * @param string $token
     * @param string|null $type
     * @return static|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Gets user ID
     * @return string|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets auth key
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates auth key
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        
        return $this->password_hash === $password;
    }

    /**
     * Generates password hash
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates auth key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}