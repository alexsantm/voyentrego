<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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
     * Displays homepage.
     *
     * @return string
     */
//        public function actionIndex()
//    {
//        //return $this->render('index');
//        //return $this->redirect(['login']);
//        if (Yii::$app->user->isGuest)
//            return $this->redirect(['user/login']);
//        else{
//            return $this->render('index');
//        }
//    }
    
            public function actionIndex()
    {
        $rol = Yii::$app->user->identity['role_id'];     
        $user_id = Yii::$app->user->identity['id'];
        $fechaactual = date("Y-m-d");;
//        print_r($fechaactual); die();
        if (Yii::$app->user->isGuest)
            return $this->redirect(['user/login']);
        else{            
                if(!empty($rol) && ($rol==2)){    
                    //return $this->render('index');
                    $searchModel = new \app\models\EnvioSearch();
                    $searchModel->user_id = $user_id;
                    $searchModel->fecha_registro = $fechaactual;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);
                }
                if(!empty($rol) && ($rol==3)){    
                    return $this->render('indexmensajero');
                }
                else if(!empty($rol) && ($rol==1)){    
                    //    return $this->render('index');    
                    $searchModel = new \app\models\EnvioSearch();
                    $searchModel->user_id = $user_id;
                    $searchModel->fecha_registro = $fechaactual;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);    
                }
                else{        
                        print_r("Hubo un error de autorizacion");
                }
        }
    }
//            public function actionRegister()
//    {
//            return $this->redirect(['user/register']);
//    }
    
                public function actionIndexmensajero()
    {
        $rol = Yii::$app->user->identity['role_id'];      
        if (Yii::$app->user->isGuest){
            $layout=false;
            return $this->redirect(['user/login']);
        }    
        else{            
            return $this->render('indexmensajero');
        }
    }
    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    /****************************************************************/
       
    public function actionTestapi()
    {
        print_r("Esta es una prueba del api"); exit;
        return $this->render('testapi');
    }
    
    public function actionConfiguracion()
    {
        return $this->render('configuracion');
    }
}
