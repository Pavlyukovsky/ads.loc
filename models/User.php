<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $accessToken
 * @property string $created_at
 *
 * @property Ad[] $ads
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['created_at'], 'safe'],
            [['username', 'password', 'auth_key', 'accessToken'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'accessToken' => 'Access Token',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Finds user by username
     * @param $username
     * @return User|array|null|\yii\db\ActiveRecord
     */
    public static function findByUsername($username)
    {
        if(!$username){
            return null;
        }

        return User::find()->where(['username' => $username])->one();
    }

    /**
     * Получаем полное имя.
     * @return string
     */
    public function getFullname()
    {
        return $this->username;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ad::className(), ['author_id' => 'id']);
    }

    /**
     * @param int|string $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findIdentity($id)
    {
        if(!$id){
            return null;
        }
        return User::find()->where(['id' => $id])->one();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * generate password
     * @param string $password
     * @return string
     */
    public function createPassword($password)
    {
        return \Yii::$app->getSecurity()->generatePasswordHash($password);
    }



}
