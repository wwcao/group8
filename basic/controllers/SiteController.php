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

class SiteController extends Controller
{

    /**
     * render Signup.php with $model = new SignupForm();
     * 
     * @return $this->render('signup', ['model' => $model])
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
            /**< activate the rule */
            $model->userExist('username', []);
        }
        
        // fail to add user, $model is changed branch statements
        return $this->render('signup', ['model' => $model]);
    }
    
    /**
     * render Signup.php with $model = new SignupForm();
     * @param $model a app\models\SignupFOrm
     * @return $this->render('signup', ['model' => $model])
     */
    public function actionSignupSuccess($model)
    {
	return $this->render('signup-success', ['model'=>$model]);
    }
    
    /**
     * render Creategroup.php with $model = new Groups();
     * 
     * @return $this->render('signup', ['model' => $model])
     */
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
                    return $this->goHome();
                } else {
                    return $this->render('say', ['message'=>'GroupErr']);
                }
            } else {
                return $this->render('error', ['name' => 'error', 'message'=>"You Created this group $group->groupname..."]);
            }
        }
	return $this->render('creategroup', ['model'=>$group]);
    }
    
    
    /**
     * render ViewGroup.php with array.key = 'myGroups','paginationMyGroup','joinedGroups','paginationJoinedGroup'
     * 
     * @return $this->render('view-group', array)
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
    
    /**
     * Help function to search database for the created groups
     * that the current logged-in user
     * 
     * @return ['myGroups'=>ActiveRecord, 'pagenation'=>Pagination]
     */
    private function getMyGroups()
    {
        $username = $this->getUser()->username;
        $queryMyGroup = Groups::find()
                ->where(['l_user' => $username]);
        $Groups = Groupmembers::find()
                ->groupBy('groupname')
                ->where(['l_user' => $username])
                ->select(['groupname'])
                ->addSelect(["GROUP_CONCAT(m_user SEPARATOR ', ') as m_users"])
                ->all();
        
        $pagination_mygroups = new Pagination([
            'defaultPageSize' => 4,
            'totalCount' => $queryMyGroup->count(),
            'pageParam' => 'my-page',
        ]);
        
        $myGroups = $queryMyGroup->orderBy('create_date')
            ->offset($pagination_mygroups->offset)
            ->limit($pagination_mygroups->limit)
            ->all();
        
        return ['myGroups'=>['Groups'=>$myGroups, 'Members'=>$Groups], 'pagenation'=>$pagination_mygroups];
    }
    
    /**
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
    
    /**
     * action without php in views
     * Update, Delete from gorups or groupmember
     * 
     * @return ['myGroups'=>ActiveRecord, 'pagenation'=>Pagination]
     */
    public function actionUserAction(){
        $request = Yii::$app->request;
        $groupinfo = $request->post();
        if($groupinfo==null){
            return $this->render('error', ['name' => 'error', 'message'=>'Request is not operated...']);
        }
        $thisuser = $this->getUser()->username;
        $action = $groupinfo['action'];
        
        $groupname = str_replace('`', ' ', $groupinfo['groupname']);
        switch($action){
            case 'delete':
                $group=  Groups::deleteAll(["l_user"=>$thisuser,"groupname"=>$groupname]);
                return $this->goHome();
            case 'leave':
                $l_user = $groupinfo['l_user'];
                $group = Groups::findOne([["l_user"=>$l_user,"groupname"=>$groupname]]);
                if(count($group)!=0&&$group->status!='c'){
                    $grp_mem = Groupmembers::deleteAll(["l_user"=>$groupinfo['l_user'],"groupname"=>$groupname, "m_user"=>$thisuser]);
                    return $this->goHome();
                }
                return $this->render('error', ['name' => 'error', 'message'=>"Unable to leave $groupname created by $l_user. Checking the status of this group"]);
            case 'close':
                $group = Groups::findOne(["l_user"=>$thisuser,"groupname"=>$groupname]);
                $group->status = 'c';
                $group->update();
                return $this->goHome();
            case 'join':
                //check existence of the group
                $l_user = $groupinfo['l_user'];
                $group = Groups::findOne([["l_user"=>$l_user,"groupname"=>$groupname]]);
                if(count($group)!=0){
                    $grp_mem = new Groupmembers;
                    $grp_mem->l_user = $l_user;
                    $grp_mem->groupname = $groupname;
                    $grp_mem->m_user = $thisuser;
                    if($grp_mem->save()){
                        return $this->goHome();
                    }
                    return $this->render('error', ['name' => 'error', 'message'=>"Unable to join $groupname created by $l_user"]);
                }
                return $this->render('error', ['name' => 'error', 'message'=>"Unable to join $groupname created by $l_user"]);
                //return $this->goHome();
            default:
                return $this->render('error', ['name' => 'error', 'message'=>"No Action"]);
        }
    }
    
    /**
     * render JoinGroup.php with array.key = Groups, keywords
     * 
     * @return $this->render('JoinGroup', array)
     */
    public function actionSearchGroup()
    {
        $request = Yii::$app->request;
        $keywords = $request->post('keywords');
        $by_interest = $request->post('by_interest');
        if($by_interest)
        {
            return $this->render('error', ['name' => 'error', 'message'=>"Page Constructing..."]);
        }
        if ($keywords!='')
        {
            return $this->actionJoinGroup($keywords);
        }
        return $this->render('search-group');
    }
    
    public function actionJoinGroup($keywords)
    {
        
        $foundGroups = $this->searchGroups($this->str2array($keywords));
        return $this->render('join-group', [
                                'Groups' => $foundGroups['Groups'],
                                //'Pagination' => $foundGroups['pagenation'],
                                'keywords' => $keywords
        ]);
    }
    
    /**
     * Helper function to convert string with seperator ','
     * to array
     * @param $str: string
     * @return render view-group.php
     */
    private function str2array($str)
    {
        //preg_match('/^[a-zA-Z].*[a-zA-Z]$/', $str) 
        $res = explode(',', $str);
        $i = 0;
        foreach($res as $r)
        {
            $res[$i] = trim($r);
            $i += 1;
        }
        return $res;
    }
    
    /**
     * Help function to search database for the groups
     * that the current logged-in user joined
     * 
     * @return ['myGroups'=>ActiveRecord, 'pagenation'=>Pagination]
     */
    private function searchGroups($keywords)
    {
        
        //TODO: Check out this functions correctly
        $username = $this->getUser()->username;
        $reserved = ['where', 'interest', 'interests', 'when', 'where'];
        $likecondition = '';
        
        foreach($keywords as $x){
            if($x=='' || in_array(strtolower($x), $reserved)){
                continue;
            }
            $likecondition .= "description like '%" . $x . "%' OR "; 
        }
        
        if($likecondition == ''){
            return ['Groups'=>[]];
        }
        
        $likecondition = substr($likecondition, 0, -4);
        $q_joinTbles = "select a.* from (select * from groups where l_user!='$username' and status!='c') a LEFT JOIN (select * from groupmembers where m_user!='$username') b on a.l_user=b.l_user and a.groupname=b.groupname";
        
        $queryGroups = Groups::findBySql(
                "select * from ($q_joinTbles) c where $likecondition order by create_date desc limit 10"
                );
        
        $queryGroups->select('*');
        $groups = $queryGroups->all();
        return ['Groups'=>$groups];
    }
    
    /**
     * render Profile.php with $model as ProfileForm if found profile;
     * render Say.php with array.key = title, message
     * 
     * @return $this->render('JoinGroup', array) or $this->render('Say', array)
     */
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
    
    /**
     * Find the logged-in user
     * 
     * @return user
     */
    private function getUser()
    {
        $id = \Yii::$app->user->getId();
        return User::findOne($id);
    }
    
    /**
     * render Say.php with array.key = message
     * 
     * @return $this->render('say', array)
     */
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
    
    /**
     * render Index.php or view-group.php
     * 
     * @return $this->render('index') if not logged in otherwise $this->actionViewGroup()
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->render('index');
        } else {
            return $this->actionViewGroup();
        }
    }
    
    /**
     * render login.php or view-group.php with Param $model = LoginForm
     * 
     * @return $this->render('login', ['model' => $model,])
     */
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


