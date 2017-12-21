<?php
namespace app\modules\api\controllers;
//namespace app\controllers;
use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;


class AuthController extends \yii\rest\Controller
{
    
    
public $user_password;

public function behaviors()
{
    return [
        'contentNegotiator' => [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                //'application/xml' => Response::FORMAT_XML,
            ],
        ],
        'verbFilter' => [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => $this->verbs(),
        ],
        'access' => [
            'class' => \yii\filters\AccessControl::className(),
            'only' => ['auth'],
            'rules' => [
                [
                    'actions' => [
                        'auth', 'login', 'logout', 'perfil', 'perfilcliente',
//                        'envios', 'enviodetalle', 'enviosmesanterior', 
//                        'enviossemestral', 'enviosanio','enviossemana','envio1', 'enviosmes','destino', 
                        'reenviopassword' 
                        ],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ],
       'authenticator' => [
            'class' => \yii\filters\auth\CompositeAuth::className(),
            'except' => ['auth', 'login', 'logout','perfil', 'perfilcliente',
//                'envios', 'enviodetalle','enviosmesanterior', 'enviossemestral',
//                'enviosanio','enviossemana','envio1', 'enviosmes','destino'
                'reenviopassword'
                ],
            'authMethods' => [
            \yii\filters\auth\HttpBasicAuth::className(),
            \yii\filters\auth\HttpBearerAuth::className(),
            \yii\filters\auth\QueryParamAuth::className(),
            ],
        ],
        'rateLimiter' => [
            'class' => \yii\filters\RateLimiter::className(),
        ],
    ];
}
    
public function actionLogin($username, $psw){
    $username = $username;
    $password = $psw;    
    $response = [];
    // validasi jika kosong

    if(empty($username) || empty($password)){
      $response = [
        'status' => 204,
        'message' => 'username & password vacios!',
      ];
    }
    else{
        // cari di database, ada nggak username dimaksud
        $user = \amnah\yii2\user\models\User::findByUsername($username);
                  
        if((!empty($user))){
               $user_id = $user->id; 
               $password_bd = $user->password;
               $validacion = Yii::$app->getSecurity()->validatePassword($password, $password_bd);    
               $resul = json_encode($validacion); 

        if($resul=='true'){
            
            //Generacion de Token
             $token = Yii::$app->security->generateRandomString();
             $model_api = new \app\models\ApiToken;
             $model_api->registrotoken($user_id, $token);
             //$foto = Yii::$app->basePath. '/web/images/fotos/'.$user->profile->foto;
             $foto = Yii::getAlias('@web').'/images/fotos/'.$user->profile->foto;
             
            $datos_bancarios = \app\models\DatosBancariosMensajero::find()->select(['numero_cuenta', 'tipo_cuenta', 'nombre_banco'])
                ->where(['user_id'=>$user_id])
                ->asArray()
                ->one();
            
            $response = [
              'status' => 'success',
              'message' => 'USUARIO LOGUEADO',
              'data' => [
                  'status'=>200,
                  'id' => $user->id,
                  //'access_token' => $user->access_token,
                  'token' => $token,                  
                  'username' => $user->username,
                  'email' => $user->email,
                  'nombre' => $user->profile->full_name,
                  'ciudad' => $user->profile->ciudad_id,
                  'cedula' => $user->profile->cedula,
                  'telefono' => $user->profile->telefono,
                  'direccion' => $user->profile->direccion,
                  'codigo_postal' => $user->profile->codigo_postal,
                  'foto' => $foto,
                  'datos_bancarios'=>$datos_bancarios,
                  // token diambil dari field auth_key
//                  'token' => $user->auth_key,
              ]
            ];
          }
          // Jika password salah maka bikin response seperti ini
          else{
            $response = [
              'status' => 'error',
              'message' => 'password incorrecto',
              'data' => '',
            ];
          }
        }
        // Jika username tidak ditemukan bikin response kek gini
        else{
          $response = [
            'status' => 'error',
            'message' => 'El Usuario no existe!',
            'data' => '',
          ];
        }
    }
    return $response;
}


public function actionPerfil($id){
    $user_id = $id;    
    /******************************************* VALIDACION DE TOKEN *************************************/
    $headers = Yii::$app->request->headers;
    $token = $headers['token'];
    $validacion = \app\modules\api\models\Auth::validatoken($user_id, $token);
    if((empty($validacion)) || ($validacion=0)){
                return $response = [
                        'message' => 'No autorizado',
                        'data' => [
                        'status' => 401,
                    ]
                ];
    }
    /******************************************* FIN VALIDACION DE TOKEN *************************************/

    if(empty($user_id)){
      $response = [
        'status' => 204,
        'message' => 'Usuario no existe!',
      ];
    }
    else{
        // Tiempo de refresco
        $time = \app\models\Opciones::find()->select(['tiempo_refresco', 'frec_almacenamiento_stand_by','frec_envio_stand_by','frec_almacenamiento_reparto','frec_envio_reparto'])->asArray()->one();
        $tiempo_refresco = $time['tiempo_refresco'];
        $frec_almacenamiento_stand_by =$time['frec_almacenamiento_stand_by'];
        $frec_envio_stand_by =$time['frec_envio_stand_by'];
        $frec_almacenamiento_reparto =$time['frec_almacenamiento_reparto'];
        $frec_envio_reparto =$time['frec_envio_reparto'];
        
        
        $query_username = \amnah\yii2\user\models\User::find()->select(['username'])->where(['id'=>$user_id])->asArray()->one();
        $username=$query_username['username'];
        $user = \amnah\yii2\user\models\User::findByUsername($username);
        $datos_bancarios = \app\models\DatosBancariosMensajero::find()->select(['numero_cuenta', 'tipo_cuenta', 'nombre_banco'])
                ->where(['user_id'=>$user_id])
                ->asArray()
                ->one();
                
        $foto = Yii::getAlias('@web').'/images/fotos/'.$user->profile->foto;            
            $response = [
              'status'=>200,
              'message' => 'Datos de Perfil de Usuario',
              'data' => [
                  'id' => $user->id,
                  'username' => $user->username,
                  'email' => $user->email,
                  'nombre' => $user->profile->full_name,
                  'ciudad' => $user->profile->ciudad_id,
                  'cedula' => $user->profile->cedula,
                  'telefono' => $user->profile->telefono,
                  'direccion' => $user->profile->direccion,
                  'codigo_postal' => $user->profile->codigo_postal,
                  'foto' => $foto,
                  'datos_bancarios'=>$datos_bancarios,
                  
                  'tiempo_refresco'=>$tiempo_refresco,
                  'frec_almacenamiento_stand_by'=>$frec_almacenamiento_stand_by,
                  'frec_envio_stand_by'=>$frec_envio_stand_by,
                  'frec_almacenamiento_reparto'=>$frec_almacenamiento_reparto,
                  'frec_envio_reparto'=>$frec_envio_reparto,
              ]
            ];
    }
    return $response;
}

public function actionPerfilcliente($id){
    $user_id = $id;    
    if(empty($user_id)){
      return $response = [
        'status' => 204,
        'message' => 'id de Usuario vacio!',
      ];
    }
    else{
        // cari di database, ada nggak username dimaksud
        $query_username = \amnah\yii2\user\models\User::find()->select(['username'])->where(['role_id'=>2])->andWhere(['id'=>$user_id])->asArray()->one();
        
        if(!empty($query_username)){
                $username=$query_username['username'];
                $user = \amnah\yii2\user\models\User::findByUsername($username);                
                $foto = Yii::getAlias('@web').'/images/fotos/'.$user->profile->foto;            
                return $response = [
                  'status'=>200,
                  'message' => 'Datos de Perfil del cliente',
                  'data' => [
                      'id' => $user->id,
                      'username' => $user->username,
                      'email' => $user->email,
                      'nombre' => $user->profile->full_name,
                      'ciudad' => $user->profile->ciudad_id,
                      'cedula' => $user->profile->cedula,
                      'telefono' => $user->profile->telefono,
                      'direccion' => $user->profile->direccion,
                      'codigo_postal' => $user->profile->codigo_postal,
                      'foto' => $foto,
                  ]
                ];
        }
        else{
                   return $response = [
                    'status' => 204,
                    'message' => 'Cliente no existe!',
                  ];
        }
    }
}


public function actionLogout($id){
    $response = [];
    if(empty($id)){
              $response = [
                'status' => 204,
                'message' => 'Id de usuario vacio!',
              ];
    }
    else{
        $user = \app\models\ApiToken::find()->where(['user_id'=>$id])->asArray()->one();
        if((empty($user))){
                $response = [
                    'status' => 204,
                    'message' => 'No existe usuario',
                ];
        }      
        else{            
            \app\models\ApiToken::deleteAll(['user_id' => $id]);
            $response = [
                    'status' => 200,
                    'message' => 'Usuario Deslogueado',
                ];
        }
    }    
    return $response;
}


  public function actionReenviopassword($email)
    {
        /** @var Mailer $mailer */
        /** @var Message $message */
        /** @var \amnah\yii2\user\models\UserToken $userToken */
      
            $user = \amnah\yii2\user\models\User::find()->where(['email'=>$email])->asArray()->one();
            if($user){
                    // modify view path to module views
                    $user_id = $user['id'];                    
                    $password = $user['password'];                    
                    $mailer = Yii::$app->mailer;
                    
                   $result= \Yii::$app->mailer->compose()         
                    ->setFrom('smunoz@qariston.com')
                    ->setTo($email)
                    //->setSubject("hola")
                    ->setSubject("Recuperación de Password")   
                    ->setHtmlBody(''
                         . '<head> <meta http-equiv=3D"Content-Type" content=3D"text/ht=ml; charset=3DUTF-8" /> <title> Ticket</title> </head>'
                          . '<body class = "bodymail" style ="background-color: #DFF0D8; font-size: 12px; padding: 25px 25px; font-family: Verdana, Geneva, sans-serif;"></div>'
                          . '<p>Hola,</p>'
                          . '<p>Usted ha solicitado el envio de su contraseña'
                          . '<p>Su contraseña es:' .$password  
                          . '<br>'                                        
                          . '<p>Atentamente<p>'
                          . '<p>VoyEntrego</p>'
                          . '</body>'
                          ) ;
//                    ->send();

                    // restore view path and return result
//                    $mailer->viewPath = $oldViewPath;
                   $decrypted = \app\modules\api\models\Auth::desencriptar(($password));
                    return $decrypted;
//                return "si existe el correo";
            }
            else{
                return "NO existe el correo";
            }
    }


//    public function actionForgot()
//    {
//        /** @var \amnah\yii2\user\models\forms\ForgotForm $model */
//
//        // load post data and send email
//        $model = $this->module->model("ForgotForm");
//        if ($model->load(Yii::$app->request->post()) && $model->sendForgotEmail()) {
//
//            // set flash (which will show on the current page)
//            Yii::$app->session->setFlash("Forgot-success", Yii::t("user", "Instructions to reset your password have been sent"));
//        }
//        return $this->render("forgot", compact("model"));
//    }
    
    
 
}