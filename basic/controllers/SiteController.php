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
            if($findUser)
            {
				$model->password = '';
                $model->userExist('username', []);
            } else {
                $user = new User;
                if($user->addUser($model))
                {
                    // succeed to add User
                    return $this->render('signup-success', ['model'=>$model]);
                } else {
                    $model->releaseErrorModel();
                    return $this->render('signup-success', ['model'=>$model]);
                }
            }
        }
        
        // fail to add user, $model is changed branch statements
        return $this->render('signup', ['model' => $model]);
    }
	
    public function actionSignupSuccess($model)
    {
	return $this->render('signup-success', ['model'=>$model]);
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
        //$addr = [];
        if (\Yii::$app->user->isGuest) {
            return $this->render('index');
        } else {
            return $this->render('say', ['message'=>""]);
        }
	//return $this->render('index', ['addr'=> $addr,]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->actionSay('nothing');
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
        return $this->render('recipes');
    }

}


