<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property string $username
 * @property string $auth_key
 * @property string $lastname
 * @property string $firstname
 * @property string $email
 * @property string $phone_num
 */
class ProfileForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'email', 'lastname', 'firstname', 'phone_num'], 'required'],
            [['username', 'email'], 'string', 'max' => 50],
            ['email', 'email'],
            //[['auth_key'], 'string', 'max' => 100],
            [['lastname', 'firstname'], 'string', 'max' => 20],
            [['phone_num'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'lastname' => 'Lastname',
            'firstname' => 'Firstname',
            'email' => 'Email',
            'phone_num' => 'Phone Num',
        ];
    }
}
