<?php
namespace app\modules\api\controllers;
use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;



class EnviosController extends \yii\rest\Controller
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
                        //'auth', 'login', 'logout', 
                        'totalenvios','envios', 
                        'enviodetalle', 'enviosmesanterior', 
                        'enviossemestral', 'enviosanio','enviossemana','envio1', 'enviosmes','destino',
                        'vehiculosmensajero',
                        'grupomensajero', 'enviospendientesfiltrados'
                        ],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ],
       'authenticator' => [
            'class' => \yii\filters\auth\CompositeAuth::className(),
            'except' => [
                //'auth', 'login', 'logout', 
                        'totalenvios','envios', 
                        'enviodetalle', 'enviosmesanterior', 
                        'enviossemestral', 'enviosanio','enviossemana','envio1', 'enviosmes','destino',
                        'vehiculosmensajero',
                        'grupomensajero', 'enviospendientesfiltrados'
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
  
 public function actionEnvios($id){
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
    $estado_envio = $headers['estado'];
        if (empty($user_id)) {
            return $response = [
                'status' => 404,
                'message' => 'No existe usuario!',
            ];
        }
        if(empty($estado_envio)) {       
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])->asArray()->all();
                             if(!empty($query)){
                                        $response = [
                                            'message' => 'Si existe envios! (sin estado)',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>$query,   
                                        ]
                                    ];
                             }
                            else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                             }
}
else{    
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                ->asArray()->all();

                        if(!empty($query)){
                                        $response = [
                                            'message' => 'Si existe envios!',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>$query,   
                                        ]
                                    ];
                         }
                        else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                         }
    }
     return $response;
}


 public function actionEnviospendientesfiltrados($id){
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
    $estado_envio = $headers['estado'];
        if (empty($user_id)) {
            return $response = [
                'status' => 404,
                'message' => 'No existe usuario!',
            ];
        }
        
         $connection = Yii::$app->getDb();
                                $command = $connection->createCommand('                                   
                                select id, estado_envio_id, mensajero_id from envio where estado_envio_id =2
                                and mensajero_id IS NULL
                                AND modo_envio in (2,3)
                                AND DATE_FORMAT(fecha_registro, "%Y-%m-%d") = DATE_FORMAT(now(), "%Y-%m-%d")
                                and id not in (select distinct(envio_id) from envios_rechazados)
                                    ');
                                $result = $command->queryAll();


                        if(!empty($result)){
                                        $response = [
                                            'message' => 'Envios Pendientes!',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>$result,   
                                        ]
                                    ];
                         }
                        else{
                                  $response = [
                                            'message' => 'No existen envios pendientes para hoy!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                         }
 
     return $response;
}


public function actionTotalenvios($id){
    $user_id = $id;    
    $headers = Yii::$app->request->headers;
    $estado_envio = $headers['estado'];
    /******************************************* VALIDACION DE TOKEN *************************************/
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
            
    //Mes actual
    $mes_actual = date("m");
    
    //Mes anterior
    $mes_anterior = date("m")-1;
    
    //Semestral
    $mes = date("m");
    $mes_inicio_semestre = $mes -6;
    
    //Anual
    $anio_actual = date("Y");
    
    //Semanal
    $week = date("W");   
    for($i=0; $i<7; $i++){
        $fechas []= date('Y-m-d', strtotime('01/01 +' . ($week - 1) . ' weeks first day +' . $i . ' day'));
    }
    $fecha_inicio = array_shift($fechas);
    $fecha_final = array_pop($fechas);
    
     if (empty($user_id)) {
            return $response = [
                'status' => 404,
                'message' => 'No existe usuario!',
            ];
        }
        
        
     /********************************************** CALIFICACIONES ************************************************/   
     //CALIFICACION MES
         $model = new \app\models\User;
         $calificacion_mes= $model->calificacion_mensual_mensajero($user_id);
         
                if(!empty($calificacion_mes)){                            
                    $calificacion_mes = floatval($calificacion_mes);
                }
                else{                            
                    $calificacion_mes = 0;
                 }

                  
     //CALIFICACION ULTIMO ENVIO:
          $calificacion_ultimo_envio= \app\modules\api\models\Auth::calificacionultimoenvio($user_id);  
          
           if(!empty($calificacion_ultimo_envio)){                            
                    $calificacion_ultimo_envio = floatval($calificacion_ultimo_envio);
                }
                else{                            
                    $calificacion_ultimo_envio = 0;
                 }
          
      //CALIFICACION ULTIMA SEMANA:
        $calificacion_ultima_semana= \app\modules\api\models\Auth::calificacionultimasemana($user_id);
        
          if(!empty($calificacion_ultima_semana)){                            
                    $calificacion_ultima_semana = floatval($calificacion_ultima_semana);
                }
                else{                            
                    $calificacion_ultima_semana = 0;
                 }
        
       //CALIFICACION TOTAL:
          $calificacion_total= \app\modules\api\models\Auth::calificaciontotal($user_id);  
          
              if(!empty($calificacion_total)){                            
                    $calificacion_total = floatval($calificacion_total);
                }
                else{                            
                    $calificacion_total = 0;
                 }
        /********************************************** FIN CALIFICACIONES ************************************************/
        
        
     if(empty($estado_envio)) { 
    /***************************************************************************************************************************/     
                        //MES ACTUAL
                        $query1 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              ->andWhere(['month(fecha_registro)'=>$mes_actual])  
                              ->asArray()->count();
                        
                            if(!empty($query1)){                            
                                $envio_mes_actual = intval ($query1);
                             }
                            else{                            
                                $envio_mes_actual = 0;
                             }
                             
                        //MES ANTERIOR:
                               $query2 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              ->andWhere(['month(fecha_registro)'=>$mes_anterior])  
                              ->asArray()->count();
                            
                            if(!empty($query2)){
                                 $envio_mes_anterior = intval ($query2);
                             }
                            else{
                                $envio_mes_anterior = 0;
                             }
                             
                        //SEMESTRAL:
                              $query3 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id','fecha_registro'
                            ])->where(['mensajero_id'=>$user_id])
                              //->andWhere(['month(fecha_registro)'=>$mes_anterior])  
                              ->andWhere(['between', 'month(fecha_registro)', $mes_inicio_semestre, $mes ]) 
                              ->asArray()->count();
                             
                              if(!empty($query3)){                            
                                 $envio_semestral = intval ($query3);
                             }
                            else{                            
                                 $envio_semestral = 0;
                             }
                             
                        //ANUAL:
                              $query4 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              ->andWhere(['year(fecha_registro)'=>$anio_actual])  
                              ->asArray()->count();
                            
                            if(!empty($query4)){                            
                                  $envio_anual = intval ($query4);
                             }
                            else{
                                 $envio_anual = 0;
                             }
                             
                        //SEMANAL:
                            $query5 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              //->andWhere(['month(fecha_registro)'=>$mes_actual]) 
                              ->andWhere(['between', 'fecha_registro', $fecha_inicio, $fecha_final ])   
                              ->asArray()->count();
                            
                            if(!empty($query5)){
                                    $envio_semanal = intval ($query5);
                             }
                            else{
                                $envio_semanal = 0;
                             }
                             
                             
                    return $response = [
                        'message' => 'Envios con estado',
                        'status' => 200,
                        'data_envios' => [
                            'envio_mensual' => $envio_mes_actual,
                            'envio_mes_anterior' => $envio_mes_anterior,
                            'envio_semestral' => $envio_semestral,
                            'envio_anual' => $envio_anual,
                            'envio_semanal' => $envio_semanal,
                        ],
                        
                        'data_calificaciones' => [
                            'calificacion_mensual' => $calificacion_mes,
                            'calificacion_ultimo_envio' => $calificacion_ultimo_envio,
                            'calificacion_ultima_semana' => $calificacion_ultima_semana,
                            //'calificacion_total' => ($calificacion_total),
                            'calificacion_total' => round( $calificacion_total, 1, PHP_ROUND_HALF_UP)
                        ]
                    ];
                             
    /***************************************************************************************************************************/                         
     }   
     else{ 
    
    /***************************************************************************************************************************/         
                    //MES ACTUAL
                     $query1 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                ->andWhere(['month(fecha_registro)'=>$mes_actual])
                                ->asArray()->count();

                            if(!empty($query1)){                            
                                $envio_mes_actual = intval ($query1);
                             }
                            else{                            
                                $envio_mes_actual = 0;
                             }
                         
                    //MES ANTERIOR:
                     $query2 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                ->andWhere(['month(fecha_registro)'=>$mes_anterior])
                                ->asArray()->count();

                            if(!empty($query2)){
                                 $envio_mes_anterior = intval ($query2);
                             }
                            else{
                                $envio_mes_anterior = 0;
                             }
                         
                     //SEMESTRAL:
                            $query3 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                //->andWhere(['month(fecha_registro)'=>$mes_anterior])
                                ->andWhere(['between', 'month(fecha_registro)', $mes_inicio_semestre, $mes ]) 
                                ->asArray()->count();

                            if(!empty($query3)){                            
                                 $envio_semestral = intval ($query3);
                             }
                            else{                            
                                 $envio_semestral = 0;
                             }
                         
                         
                       //ANUAL:
                        $query4 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                 ->andWhere(['year(fecha_registro)'=>$anio_actual])  
                                ->asArray()->count();

                            if(!empty($query4)){                            
                                  $envio_anual = intval ($query4);
                             }
                            else{
                                 $envio_anual = 0;
                             } 
                         
                        //SEMANAL 
                           $query5 = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                ->andWhere(['between', 'fecha_registro', $fecha_inicio, $fecha_final ])   
                                ->asArray()->count();

                            if(!empty($query5)){
                                    $envio_semanal = intval ($query5);
                             }
                            else{
                                $envio_semanal = 0;
                             } 
                             
                             
                        return $response = [
                        'message' => 'Envios sin estado',
                        'status' => 200,
                        'data_envios' => [
                            'envio_mensual' => $envio_mes_actual,
                            'envio_mes_anterior' => $envio_mes_anterior,
                            'envio_semestral' => $envio_semestral,
                            'envio_anual' => $envio_anual,
                            'envio_semanal' => $envio_semanal,
                        ], 
                         
                        'data_calificaciones' => [
                            'calificacion_mensual' => $calificacion_mes,
                            'calificacion_ultimo_envio' => $calificacion_ultimo_envio,
                            'calificacion_ultima_semana' => $calificacion_ultima_semana,
                            'calificacion_total' => round( $calificacion_total, 1, PHP_ROUND_HALF_UP)
                        ]    
                    ];
    /***************************************************************************************************************************/     
     }
}


 public function actionEnviosmes($id){
    $user_id = $id;    
    $headers = Yii::$app->request->headers;
    $estado_envio = $headers['estado'];
    $mes_actual = date("m");
    /******************************************* VALIDACION DE TOKEN *************************************/
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
        if (empty($user_id)) {
            return $response = [
                'status' => 404,
                'message' => 'No existe usuario!',
            ];
        }
        if(empty($estado_envio)) {       
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              ->andWhere(['month(fecha_registro)'=>$mes_actual])  
                              ->asArray()->count();
                             if(!empty($query)){
                                        $response = [
                                            'message' => 'Si existe envios! (sin estado)',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                             }
                            else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                             }
}
else{    
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                ->andWhere(['month(fecha_registro)'=>$mes_actual])
                                ->asArray()->count();

                        if(!empty($query)){
                                        $response = [
                                            'message' => 'Si existe envios! (con estado)',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                         }
                        else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                         }
    }
     return $response;
}

 public function actionEnviosmesanterior($id){
    $user_id = $id;    
    $headers = Yii::$app->request->headers;
    $estado_envio = $headers['estado'];
    $mes_anterior = date("m")-1;
    /******************************************* VALIDACION DE TOKEN *************************************/
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
        if (empty($user_id)) {
            return $response = [
                'status' => 404,
                'message' => 'No existe usuario!',
            ];
        }
        if(empty($estado_envio)) {       
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              ->andWhere(['month(fecha_registro)'=>$mes_anterior])  
                              ->asArray()->count();
                             if(!empty($query)){
                                        $response = [
                                            'message' => 'Si existe envios! (sin estado)',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                             }
                            else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                             }
}
else{    
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                ->andWhere(['month(fecha_registro)'=>$mes_anterior])
                                ->asArray()->count();

                        if(!empty($query)){
                                        $response = [
                                            'message' => 'Si existe envios!',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),    
                                        ]
                                    ];
                         }
                        else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                         }
    }
     return $response;
}

public function actionEnviossemestral($id){
    $user_id = $id;    
    $headers = Yii::$app->request->headers;
    $estado_envio = $headers['estado'];
    $mes = date("m");
    $mes_inicio_semestre = $mes -6;
//    return $mes_inicio_semestre;
    /******************************************* VALIDACION DE TOKEN *************************************/
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
        if (empty($user_id)) {
            return $response = [
                'status' => 404,
                'message' => 'No existe usuario!',
            ];
        }
        if(empty($estado_envio)) {       
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id','fecha_registro'
                            ])->where(['mensajero_id'=>$user_id])
                              //->andWhere(['month(fecha_registro)'=>$mes_anterior])  
                              ->andWhere(['between', 'month(fecha_registro)', $mes_inicio_semestre, $mes ]) 
                              ->asArray()->count();
                             if(!empty($query)){
                                        $response = [
                                            'message' => 'Envios semestrales sin estado',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                             }
                            else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                             }
}
else{    
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                //->andWhere(['month(fecha_registro)'=>$mes_anterior])
                                ->andWhere(['between', 'month(fecha_registro)', $mes_inicio_semestre, $mes ]) 
                                ->asArray()->count();

                        if(!empty($query)){
                                        $response = [
                                            'message' => 'Envios semestrales con estado',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                         }
                        else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                         }
    }
     return $response;
}



 public function actionEnviosanio($id){
    $user_id = $id;    
    $headers = Yii::$app->request->headers;
    $estado_envio = $headers['estado'];
    $anio_actual = date("Y");
    /******************************************* VALIDACION DE TOKEN *************************************/
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
        if (empty($user_id)) {
            return $response = [
                'status' => 404,
                'message' => 'No existe usuario!',
            ];
        }
        if(empty($estado_envio)) {       
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              ->andWhere(['year(fecha_registro)'=>$anio_actual])  
                              ->asArray()->count();
                             if(!empty($query)){
                                        $response = [
                                            'message' => 'Envios anuales sin estado',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                             }
                            else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                             }
}
else{    
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                 ->andWhere(['year(fecha_registro)'=>$anio_actual])  
                                ->asArray()->count();

                        if(!empty($query)){
                                        $response = [
                                            'message' => 'Envios anuales con estado',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                         }
                        else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                         }
    }
     return $response;
}

public function actionEnviossemana($id){
    $user_id = $id;    
    $headers = Yii::$app->request->headers;
    $estado_envio = $headers['estado'];
    
    $week = date("W");   
    for($i=0; $i<7; $i++){
        $fechas []= date('Y-m-d', strtotime('01/01 +' . ($week - 1) . ' weeks first day +' . $i . ' day'));
    }
    $fecha_inicio = array_shift($fechas);
    $fecha_final = array_pop($fechas);

    /******************************************* VALIDACION DE TOKEN *************************************/
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
        if (empty($user_id)) {
            return $response = [
                'status' => 404,
                'message' => 'No existe usuario!',
            ];
        }
        if(empty($estado_envio)) {       
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              //->andWhere(['month(fecha_registro)'=>$mes_actual]) 
                              ->andWhere(['between', 'fecha_registro', $fecha_inicio, $fecha_final ])   
                              ->asArray()->count();
                             if(!empty($query)){
                                        $response = [
                                            'message' => 'Envios semanales con estado',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                             }
                            else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                             }
}
else{    
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id'])
                                ->where(['mensajero_id'=>$user_id])
                                ->andWhere(['estado_envio_id'=>$estado_envio])
                                ->andWhere(['between', 'fecha_registro', $fecha_inicio, $fecha_final ])   
                                ->asArray()->count();

                        if(!empty($query)){
                                        $response = [
                                            'message' => 'Envios semanales sin estado',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>intval($query),   
                                        ]
                                    ];
                         }
                        else{
                                  $response = [
                                            'message' => 'No existe envios para esta semana',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                         }
    }
     return $response;
}

 public function actionEnviodetalle(){
    $headers = Yii::$app->request->headers;
    $envio_id = $headers['envio']; 
//    print_r($envio_id); die();
if(empty($envio_id)) {       
          $response = [
                    'message' => 'No existe id de envio!',
                    'data' => [
                    'status' => 204,
                ]
         ];
}
else{    
        $query = \app\models\Envio::find()
                ->where(['id'=>$envio_id])->asArray()->one();
         if(!empty($query)){
               $query_destinos = \app\models\Destino::find()->where(['envio_id'=>$envio_id])->asArray()->all();     
               if(!empty($query_destinos)){    
                    $datos = array_merge($query, array('destinos' => $query_destinos));
                    $response= [
                        'message' => 'Detalle de Envios y Destinos:',
                        'data' => [
                        'status' => 200,
                        'data'=>$datos,   
                        ]
                    ];                                       
               }
               else{
//                     $response_destinos = [
//                        'message' => 'No existe destinos!',
//                        'status' => 204,
////                                            'data' => [
////                                            'status' => 200,
////                                        ]
//                ];
                        $response = [
                                'message' => 'Envio sin destinos',
                                'data' => [
                                'status' => 200,
                                'detalle'=>$query,                              
                            ]
                        ];
               }                                        
         }
        else{
              $response = [
                        'message' => 'No existe envios!',
                        'status' => 204,    
                ];
         }                    
}
return $response;
}

 public function actionEnvio1($id){
    $user_id = $id;    
    $headers = Yii::$app->request->headers;
    $estado_envio = $headers['estado'];
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
if(empty($estado_envio)) {       
                        $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])->asArray()->all();
                        if(empty($id)){
                          $response = [
                            'status' => 404,
                            'message' => 'No existe usuario!',
                          ];
                        }
                        else{
                             if((!empty($user_id)) && ((!empty($query)))){
                                        $response = [
                                            'message' => 'Si existe envios! (sin estado)',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>$query,   
                                        ]
                                    ];
                             }
                            else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                             }
                        }
}
else{    
                            $query = \app\models\Envio::find()->select(['id','estado_envio_id','mensajero_id',
                            ])->where(['mensajero_id'=>$user_id])
                              ->andWhere(['estado_envio_id'=>$estado_envio])
                              ->asArray()->all();
                        if(empty($id)){
                          $response = [
                            'status' => 404,
                            'message' => 'No existe usuario!',
                          ];
                        }
                        else{
                             if((!empty($user_id)) && ((!empty($query)))){
                                        $response = [
                                            'message' => 'Si existe envios!',
                                            'data' => [
                                            'status' => 200,
                                            'data'=>$query,   
                    //                        'obs'=>$query[0]['observacion'],   
                                        ]
                                    ];
                             }
                            else{
                                  $response = [
                                            'message' => 'No existe envios!',
                                            'data' => [
                                            'status' => 204,
                                        ]
                                    ];
                             }
                        }
}
     return $response;
}



 
}