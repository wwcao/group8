<?php
namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
	/*
	1. add variables for signup page
	2. add rule for the fields
	*/
    public $username;
    public $password;
    public $f_name;
    public $l_name;
    public $email;
	
	const WEAK = 0;
	const STRONG = 1;

    public function rules()
    {
        return [
            [['username','password','f_name', 'l_name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
                'username'  => 'Username',
                'password'  => 'Password',
                'f_name'    => 'Firstname',
                'l_name'    => 'Lastname',
                'email'     => 'Email',
        ];
    }
    
    public function releaseErrorModel()
    {
	$this->username = 'Unknown Error';
        $this->email = 'Unknown Error';
        $this->password = '********';
        $this->f_name = 'Unknown Error';
        $this->l_name = 'Unknown Error';
	return $this;
    }
    
    /**
     * Add error to Signup Form & change password to empty
     * @param type $attribute
     * @param type $params
     */
    public function userExist($attribute, $params)
    {
        $this->password = '';
        $this->addError($attribute, 'username exists');
    }
}

