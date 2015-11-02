<?php
namespace app\models;

use Yii;
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
}

