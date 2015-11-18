<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\User;
use app\models\ProfileForm;
use app\models\Groups;

class SiteController extends Controller
{

    /**
     * Controll redirection of Signup Form
     * 
     * @return $this->render()
     */
    public function actionSignup()
    {	
	$model = new SignupForm();
		
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            $findUser = User::findByUsername($model->username);
            if(!$findUser)
            {
                $user = new User;
                if($user->addUser($model))
                {
                    // succeed to add User
                    return $this->render('signup-success', ['model'=>$model]);
                }
                
                $model->releaseErrorModel();
                return $this->render('signup-success', ['model'=>$model]);
            }
            $model->password = '';
            $model->userExist('username', []);

        }
        
        // fail to add user, $model is changed branch statements
        return $this->render('signup', ['model' => $model]);
    }
	
    public function actionSignupSuccess($model)
    {
	return $this->render('signup-success', ['model'=>$model]);
    }
    
    public function actionCreategroup()
    {
        $user = $this->getUser();
        
        $group = new Groups();

	if ($group->load(Yii::$app->request->post()) && $group->validate()) 
        {
	   
        }		
	return $this->render('creategroup', ['model'=>$group]);
        $group->Num_Group($user->username);
        
    }
    
    public function actionProfile()
    {
        $id = \Yii::$app->user->getId();
        $user = User::findOne($id);
        
        //$profile = new ProfileForm();
        $profile = ProfileForm::findOne($user->username);
        if ($profile->load(Yii::$app->request->post()) && $profile->validate()) 
        {
            if($profile->save())
            {
                return $this->render('say', ['message'=>'You submited your profile successfully!']);
            }
        }
        return $this->render('profile', ['model'=>$profile]);
    }
    
    private function getUser()
    {
        $id = \Yii::$app->user->getId();
        return User::findOne($id);
    }
	
    public function actionSay($message)
    {
	return $this->render('say', ['message'=>$message]);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->render('index');
        } else {
            return $this->render('say', ['message'=>""]);
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->actionSay('You have logged in successfully!');
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionRecipes()
    {
        return $this->render('recipes');
    }
    
    public function actionDog()
    {
        $id = \Yii::$app->user->getId();
        if($id != '')
        {
            $user = User::findOne($id);
            $message = $user->username . ' ' .$id;
            return $this->actionSay($message);
        }
        return $this->actionSay($id);
    }

}


