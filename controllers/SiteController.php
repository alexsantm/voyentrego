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
        $user = Yii::$app->user->identity;        
        $rol = Yii::$app->user->identity['role_id'];     
        $user_id = Yii::$app->user->identity['id'];
        $fechaactual = date("Y-m-d");
           
        if (Yii::$app->user->isGuest)
            return $this->redirect(['user/login']);
        else{       
            
        /****************** MENSAJERO***************************/
            $model = new \app\models\User;
            $calificacion_mes= $model->calificacion_mensual_mensajero($user_id);
            $no_envios_exitosos= $model->envios_exitosos_mes_mensajero($user_id);
            $no_envios_asignados= $model->envios_asignados_hoy_mensajero($user_id);
            $no_envios_asignados_mes= $model->envios_asignados_mes_mensajero($user_id);
            $favoritismo= $model->favoritismo($user_id);
        /******************FIN MENSAJERO***************************/
            
        /****************** USUARIO ***************************/
            $envios_inicializados_hoy_usuario= $model->envios_inicializados_hoy_usuario($user_id);
            $envios_pendientes_hoy_usuario= $model->envios_pendientes_hoy_usuario($user_id);
            $envios_finalizados_hoy_usuario= $model->envios_finalizados_hoy_usuario($user_id);
        /******************FIN USUARIO***************************/    
        
            
            /***************Promociones*************/
//            $consulta = \app\models\Descuento::find()->asArray()->one();
//            $foto_promocion = $consulta['archivo_promocion'];
//            $fecha_inicio = $consulta['fecha_inicio'];
//            $fecha_fin = $consulta['fecha_fin'];
            /***************Fin Promociones*************/
            if(empty($user->profile->full_name)){       //Si no ha ingresado un nombre de usuario pues tiene que agregarlo
                ?><?= Yii::$app->session->setFlash('danger', '<center><div><h3>ANTES DE COMENZAR:</h3> <h4>Por favor ingrese su información de Perfil</h4></div></center>');  ?><?php  
                //return $this->redirect(['user/perfil']);                
                return $this->redirect(['user/profile']);                
            }
                if(!empty($rol) && ($rol==2) || ($rol==4)|| ($rol==5)){    
                    //return $this->render('index');
                    $searchModel = new \app\models\EnvioSearch();
                    $searchModel->user_id = $user_id;
                    $searchModel->fecha_registro = $fechaactual;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        
                        //Usuario
                        'envios_inicializados_hoy_usuario'=>$envios_inicializados_hoy_usuario,
                        'envios_pendientes_hoy_usuario'=>$envios_pendientes_hoy_usuario,
                        'envios_finalizados_hoy_usuario'=>$envios_finalizados_hoy_usuario,
                        
                        //Datos enviados desde Descuento:
//                        'foto_promocion' => $foto_promocion,
//                        'fecha_inicio' => $fecha_inicio,
//                        'fecha_fin' => $fecha_fin,
                    ]);
                }
                if(!empty($rol) && ($rol==3)){    
                    //return $this->render('indexmensajero');
                    $searchModel = new \app\models\EnvioSearch();
                    $searchModel->mensajero_id = $user_id;
                    $searchModel->fecha_registro = $fechaactual;
                    $searchModel->estado_envio_id != 3;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    return $this->render('indexmensajero', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        
                        //Mensajero
                        'calificacion_mes' => $calificacion_mes,
                        'no_envios_asignados'=>$no_envios_asignados,
                        'no_envios_exitosos'=>$no_envios_exitosos,
                        'favoritismo'=>$favoritismo,
                    ]);                                        
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
                        //Datos enviados desde Descuento:
//                        'foto_promocion' => $foto_promocion,
//                        'fecha_inicio' => $fecha_inicio,
//                        'fecha_fin' => $fecha_fin,
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
    
     public function actionSoporte()
    {
        return $this->render('soporte');
    }
    
     public function actionContactanos()
    {
        return $this->render('contactanos');
    }
    
    public function action401()
    {
        return $this->render('401');
    }
    
      public function actionHome()
    {
        $this->layout = false;  
        return $this->render('home');
    }
    
    

}
