<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $username
 * @property string $password
 * @property string $email
 */
class Users extends \yii\db\ActiveRecord
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
            [['username'], 'required'],
            [['username'], 'string', 'max' => 45],
            [['password', 'email'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
        ];
    }

	public function addNewUser($new_user)
	{	
		$this->username = $new_user->username;
		$this->password = $new_user->password;
		$this->email = $new_user->email;
		return $this->save();
	}
}
