<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
            [['username', 'password', 'auth_key'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['password', 'auth_key', 'access_token'], 'string', 'max' => 100]
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
            'access_token' => 'Access Token',
        ];
    }
    
    /**
     * Add a new user to the database
     * @param SignupForm
     * return Boolean: true if insertion succeed, otherwise, false.
     */
    public function addUser($model)
    {
        $this->id = '';
        $this->username = $model->username;
        $this->password = $model->password;
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
        $this->access_token = Yii::$app->getSecurity()->generateRandomString();
        $profile = new ProfileForm;
        if($profile->addUserProfile($this, $model))
        {               
            return $this->save();
        }
        return false;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return User::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  $username string
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($auth_key)
    {
        return $this->auth_key === $auth_key;
    }

    /**
     * Validates password
     *
     * @param $password string password to validate 
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
