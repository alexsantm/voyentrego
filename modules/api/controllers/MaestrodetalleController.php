<?php
namespace app\modules\api\controllers;
//namespace app\controllers;
use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;


class MaestrodetalleController extends \yii\rest\Controller
{
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
                    'actions' => ['ciudad', 'estadoenvio', 'tipoenvio', 'dimensiones','statusmensajero', 'estadovehiculos'
                        ],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ],
       'authenticator' => [
            'class' => \yii\filters\auth\CompositeAuth::className(),
            'except' => ['ciudad', 'estadoenvio', 'tipoenvio', 'dimensiones','statusmensajero', 'estadovehiculos'
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

/********************************************************************************************************************************/
/********************************************************************************************************************************/

//public function actionCiudad($ciudad_id){
//    if(empty($ciudad_id)){
//              $response = [
//                'status' => 204,
//                'message' => 'Id de ciudad vacio!',
//              ];
//    }
//    else{
//        $query = \app\models\Ciudad::find()->where(['id'=>$ciudad_id])->asArray()->one();
//        $ciudad = $query['ciudad'];
////        print_r($ciudad); die();
//        if((empty($ciudad))){
//                $response = [
//                    'status' => 204,
//                    'message' => 'No existe ciudad',
//                ];
//        }      
//        else{            
//              $response = [
//                        'message' => 'Si existe ciudad!',
//                        'status' => 200,
//                        'ciudad'=>$ciudad,    
//                ];
//        }
//    }    
//    return $response;
//}

public function actionCiudad(){    
               $query = \app\models\Ciudad::find()->asArray()->all();     
               if(!empty($query)){    
                    return $response= [
                        'message' => 'Ciudades',
                        'status' => 200,                                                
                        'ciudad'=>$query,                           
                    ];                                       
               }
               else{
                    return $response = [
                    'status' => 204,
                    'message' => 'No existe ciudades',
                ];
               }
}


public function actionEstadoenvio(){    
               $query = \app\models\EstadoEnvio::find()->asArray()->all();
               if(!empty($query)){    
                    return $response= [
                        'message' => 'Estados Envio',
                        'status' => 200,                                                
                        'estados'=>$query,                           
                    ];                                       
               }
               else{
                    return $response = [
                    'status' => 204,
                    'message' => 'No existe estados de envio',
                ];
               }
}


public function actionTipoenvio(){    
               $query = \app\models\TipoEnvio::find()->asArray()->all();     
               if(!empty($query)){    
                    return $response= [
                        'message' => 'Tipos de Envio',
                        'status' => 200,                                                
                        'tipo_envio'=>$query,                           
                    ];                                       
               }
               else{
                    return $response = [
                    'status' => 204,
                    'message' => 'No existe tipo de envio',
                ];
               }
}

public function actionDimensiones(){    
               $query = \app\models\Dimensiones::find()->asArray()->all();
               if(!empty($query)){    
                    return $response= [
                        'message' => 'Dimensiones',
                        'status' => 200,                                                
                        'dimensiones'=>$query,                           
                    ];                                       
               }
               else{
                    return $response = [
                    'status' => 204,
                    'message' => 'No existe dimensiones',
                ];
               }
}

public function actionStatusmensajero(){    
               $query = \app\models\StatusMensajero::find()->asArray()->all();
               if(!empty($query)){    
                    return $response= [
                        'message' => 'Status Mensajero',
                        'status' => 200,                                                
                        'dimensiones'=>$query,                           
                    ];                                       
               }
               else{
                    return $response = [
                    'status' => 204,
                    'message' => 'No existe status de mensajero',
                ];
               }
}

public function actionEstadovehiculos(){    
               $query = \app\models\Estado::find()->asArray()->all();
               if(!empty($query)){    
                    return $response= [
                        'message' => 'Estado',
                        'status' => 200,                                                
                        'estados'=>$query,                           
                    ];                                       
               }
               else{
                    return $response = [
                    'status' => 204,
                    'message' => 'No existe estado',
                ];
               }
}



}