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
            [['username', 'email', 'lastname', 'firstname', 'phone_num'], 'required'],
            [['username', 'email'], 'string', 'max' => 50],
            ['email', 'email'],
            [['lastname', 'firstname'], 'string', 'max' => 20],
            [['phone_num'], 'string', 'max' => 10],
            ['primaryKey','safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'lastname' => 'Lastname',
            'firstname' => 'Firstname',
            'email' => 'Email',
            'phone_num' => 'Phone Num',
        ];
    }
    
    /**
     * initializing the object (test1)
     *
     * @return None
     */
    public function initialize()
    {
        $this->username = '';
        $this->lastname = '';
        $this->email = '';
        $this->phone_num = '';
    }
    
    /**
     * initializing the object (test2)
     *
     * @return None
     */
    public function test_initialize()
    {
        $this->username = 'admin';
        $this->lastname = '';
        $this->email = '';
        $this->phone_num = '';
    }
    
    /**
     * Update Profile if existing, Add if the record is new
     *
     * @param  $user: Object User
     * @param  $signupform Object SignupForm
     * @return boolean if password provided is valid for current user
     */
    public function addUserProfile($user, $signupfrom)
    {
        $this->initialize();
        $this->username = $user->username;
        $this->email = $signupfrom->email;
        $this->lastname = $signupfrom->l_name;
        $this->firstname = $signupfrom->f_name;
        return $this->save(false);
    }
}
