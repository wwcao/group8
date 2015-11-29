<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\User;
use app\models\ProfileForm;
use app\models\Groups;
use app\models\Groupmembers;
use app\models\SearchKW;

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
        $group->l_user = $user->username;
        $group->create_date = date("Y-m-d");
        $group->status = 'o';
	if ($group->load(Yii::$app->request->post()) && $group->validate()) 
        {
            if(!$group->groupExist())
            {
                if($group->save())
                {
                    return $this->render('say', ['message'=>'Group is Created']);
                } else {
                    return $this->render('say', ['message'=>'GroupErr']);
                }
            } else {
                return $this->render('say', ['message'=>'You created ' . $group->groupname . '!']);
            }
        }
	return $this->render('creategroup', ['model'=>$group]);
    }
    
    
    // Start View Group
    /*
     * Action: Help function to search database for the created groups
     * that the current logged-in user
     * 
     * @return render view-group.php
     */
    public function actionViewGroup()
    {
        
        // add post check
        
        $myGroups = $this->getMyGroups();
        $joinedGroups = $this->getJoinedGroups();

        return $this->render('view-group', [
            'myGroups' => $myGroups['myGroups'],
            'paginationMyGroup' => $myGroups['pagenation'],
            'joinedGroups' => $joinedGroups['joinedGroups'],
            'paginationJoinedGroup' => $joinedGroups['pagenation'],
        ]);
    }
    
    /*
     * Help function to search database for the created groups
     * that the current logged-in user
     * 
     * @return ['myGroups'=>ActiveRecord, 'pagenation'=>Pagination]
     */
    private function getMyGroups()
    {
        $queryMyGroup = Groups::find()
                ->where(['l_user' => $this->getUser()->username]);
        
        $pagination_mygroups = new Pagination([
            'defaultPageSize' => 4,
            'totalCount' => $queryMyGroup->count(),
            'pageParam' => 'my-page',
        ]);

        $myGroups = $queryMyGroup->orderBy('create_date')
            ->offset($pagination_mygroups->offset)
            ->limit($pagination_mygroups->limit)
            ->all();
        return ['myGroups'=>$myGroups, 'pagenation'=>$pagination_mygroups];
    }
    
    /*
     * Help function to search database for the groups
     * that the current logged-in user joined
     * 
     * @return ['myGroups'=>ActiveRecord, 'pagenation'=>Pagination]
     */
    private function getJoinedGroups()
    {
        $NJ = 'NATURAL JOIN';
        $queryJoinedGroup = Groups::find()->join($NJ, ['groupmembers'])
                ->where(['m_user' => $this->getUser()->username])
                ->select('*');

                
        $pagination_joinedgroup = new Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $queryJoinedGroup->count(),
            'pageParam' => 'joined-page',
        ]);
        
        $joinedGroups = $queryJoinedGroup
                ->offset($pagination_joinedgroup->offset)
                ->limit($pagination_joinedgroup->limit)
                ->all();
        return ['joinedGroups'=>$joinedGroups, 'pagenation'=>$pagination_joinedgroup];
    }
    // End ViewGroup
    
    public function actionSearchGroup()
    {
        $keywords = new SearchKW();
        if ($keywords->load(Yii::$app->request->post()) && $keywords->validate())
        {
            $foundGroups = $this->searchGroups($this->str2array($keywords->keywords));
            return $this->render('search-group', [
            'Groups' => $foundGroups['Groups'],
            'Pagination' => $foundGroups['pagenation'],
            'keywords' => $keywords
            ]);
        }
        return $this->render('search-group', [
            'Groups' => [],
            'Pagination' => [],
            'keywords' => $keywords
        ]);
    }
    
    public function actionActionOnGroup($acction, $id){
        return $this->render('index');
    }
    
    private function str2array($str)
    {
        $res = explode(',', $str);
        $i = 0;
        foreach($res as $r)
        {
            $res[$i] = trim($r);
            $i += 1;
        }
        return $res;
    }
    
    /*
     * Help function to search database for the groups
     * that the current logged-in user joined
     * 
     * @return ['myGroups'=>ActiveRecord, 'pagenation'=>Pagination]
     */
    private function searchGroups($keywords)
    {
        $NJ = 'NATURAL JOIN';
        
        //TODO: Check out this functions correctly
        $username = $this->getUser()->username;
        $subquery = Groupmembers::find()
                ->where(['l_user' => $username])
                ->andwhere(['m_user' => $username]);
        $queryGroups = Groups::find()->join($NJ, [$subquery])
                ->where(['or like', 'description', $keywords]);
        $queryGroups->select('*');
        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $queryGroups->count(),
            'pageParam' => 'joined-page',
        ]);
        $groups = $queryGroups
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        return ['Groups'=>$groups, 'pagenation'=>$pagination];
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
                return $this->render('say', ['title'=>'successfully', 'message'=>'<3>You submited your profile successfully!</h3>']);
            }
        }
        return $this->render('profile', ['model'=>$profile]);
    }
    
    /*
     * Find the logged-in user
     * 
     * @return user
     */
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
            return $this->actionViewGroup();
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('index');
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


