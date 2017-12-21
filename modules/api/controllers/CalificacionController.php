<?php
namespace app\modules\api\controllers;
//namespace app\controllers;
use Yii;
use yii\web\Response;


class CalificacionController extends \yii\rest\Controller
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
                    'actions' => ['calificacion', 'calificacionultimoenvio', 'calificacionultimasemana', 'calificacionultimomes'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ],
       'authenticator' => [
            'class' => \yii\filters\auth\CompositeAuth::className(),
            'except' => ['calificacion', 'calificacionultimoenvio', 'calificacionultimasemana', 'calificacionultimomes'],
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
    
/********************************************************************************************************************************/
/********************************************************************************************************************************/


    public function actionCalificacion($id){
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
    if(empty($id)){
      $response = [
        'status' => 204,
        'message' => 'No existe usuario!',
      ];
    }
    else{
          $model = new \app\models\User;
          $calificacion_mes= $model->calificacion_mensual_mensajero($user_id);
         if((!empty($user_id))){
                     $response = [
                        'message' => 'Si existe calificacion!',
                        'data' => [
                        'status' => 200,
                        'calificacion'=>floatval($calificacion_mes),    
                    ]
                ];
         }
         else{
              $response = [
                        'message' => 'No existe calificacion!',
                        'data' => [
                        'status' => 204,
                    ]
                ];
         }
    }   
    return $response;
}


    public function actionCalificacionultimoenvio($id){
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
    if(empty($id)){
      return $response = [
        'status' => 204,
        'message' => 'No existe usuario!',
      ];
    }
    else{
          $calificacion= \app\modules\api\models\Auth::calificacionultimoenvio($user_id);  
          if(empty($calificacion)){
              return $response = [
                        'message' => 'Calificacion del ultimo envio (no hay calificacion)',
                        'data' => [
                        'status' => 200,
                        'calificacion'=>0,    
                    ]
                ];
          }
          else{
              return $response = [
                        'message' => 'Calificacion del ultimo envio',
                        'data' => [
                        'status' => 200,
                        'calificacion'=>floatval($calificacion),    
                    ]
                ];
          }
    }   
}

    public function actionCalificacionultimasemana($id){
    $user_id = $id;
    /******************************************* VALIDACION DE TOKEN *************************************/
    $headers = Yii::$app->request->headers;
    $token = $headers['token'];
    $validacion = \app\modules\api\models\Auth::validatoken($user_id, $token);
    if((empty($validacion)) || ($validacion=0)){
                return $response = [
                        'message' => 'Usuario No Autorizado',
                        'data' => [
                        'status' => 401,
                    ]
                ];
    }
    /******************************************* FIN VALIDACION DE TOKEN *************************************/    
    if(empty($id)){
      return $response = [
        'status' => 204,
        'message' => 'No existe usuario!',
      ];
    }
    else{
          $calificacion= \app\modules\api\models\Auth::calificacionultimasemana($user_id);
          if(empty($calificacion)){
              return $response = [
                        'message' => 'Calificacion de la ultima semana (no hay calificacion)',
                        'data' => [
                        'status' => 200,
                        'calificacion'=>0,    
                    ]
                ];
          }
          else{
              return $response = [
                        'message' => 'Calificacion de la ultima semana',
                        'data' => [
                        'status' => 200,
                        'calificacion'=>floatval($calificacion),    
                    ]
                ];
          }
    } 
}

    public function actionCalificacionultimomes($id){
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
    if(empty($id)){
      return $response = [
        'status' => 204,
        'message' => 'No existe usuario!',
      ];
    }
    else{
          $calificacion= \app\modules\api\models\Auth::calificacionultimomes($user_id);  
          if(empty($calificacion)){
              return $response = [
                        'message' => 'Calificacion del ultimo mes (no hay calificacion)',
                        'data' => [
                        'status' => 200,
                        'calificacion'=>0,    
                    ]
                ];
          }
          else{
              return $response = [
                        'message' => 'Calificacion del ultimo mes',
                        'data' => [
                        'status' => 200,
                        'calificacion'=>floatval($calificacion),    
                    ]
                ];
          }
    } 
    }
    
    
    
    
    
}