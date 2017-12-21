<?php
namespace app\modules\api\controllers;
//namespace app\controllers;
use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;


class MensajeroController extends \yii\rest\Controller
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
                    'actions' => ['vehiculosmensajero', 'statusmensajero', 'grupomensajero',
                        'notificaciones', 'cambiopassword', 'aceptarechazaenvio', 'comentario'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ],
       'authenticator' => [
            'class' => \yii\filters\auth\CompositeAuth::className(),
            'except' => ['vehiculosmensajero', 'statusmensajero', 'grupomensajero', 
                'notificaciones', 'cambiopassword', 'aceptarechazaenvio', 'comentario'],
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

 public function actionVehiculosmensajero($id){
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
    $query = \app\models\DatosVehiculo::find()->where(['user_id'=>$user_id])->asArray()->all();    
    if(empty($query)) {       

                    return $response = [
                            'status' => 404,
                            'message' => 'No existen vehiculos!',
                          ];
    }
    else{    
                    return $response = [
                        'message' => 'Vehiculos del mensajero!',
                        'status' => 200,
//                        'data' => [                        
                        'data'=>$query,   
//                    ]
                ];
    }

}


 public function actionStatusmensajero($id){
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
    $status = $headers['status'];
    $query = \app\models\User::updateAll(['status_id' => $status], 'id = '. "'".$user_id."'" );
    if(empty($query)) {       

                    return $response = [
                            'status' => 404,
                            'message' => 'No se hizo ningua actualizacion',
                          ];
    }
    else{    
                    return $response = [
                        'message' => 'Status de mensajero actualizado!',
                        'status' => 200,
                ];
    }

}



 public function actionGrupomensajero($id){
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
//    $id_grupo = \app\models\UserGrupo::find()->select(['grupo_usuarios_id'])->where(['user_id'=>$user_id])->asArray()->one(); 
    
    $connection = Yii::$app->getDb();
    $command = $connection->createCommand('select
                            cast(ug.user_id as UNSIGNED) as user_id,
                            round((
                            select
                                avg(c.calificacion)
                                from
                                calificacion c, envio e
                                where
                                c.mensajero_id = ug.user_id
                            ),2) as calificacion,
                            p.full_name,
                            g.grupo,
                            ug.id as id_grupo,
                            g.responsable_user_id
                            from
                            grupo_usuarios g,
                            user_grupo ug,
                            profile p
                            where
                            g.id = ug.grupo_usuarios_id
                            and ug.user_id = p.user_id
                            and g.responsable_user_id ='. $user_id );
    $datos = $command->queryAll();

    foreach($datos as $d){
        $user_id = $d['user_id'];
        $calificacion = $d['calificacion'];
        $grupo =  $d['grupo'];
        $id_grupo =    $d['id_grupo'];
        $responsable_user_id =  $d['responsable_user_id'] ;  
    }
//    $datos = array_merge(array('user'=>$user_id));
//    print_r($datos); die();
    
    if(empty($datos)) {       
                    return $response = [
                            'status' => 204,
                            'message' => 'No existe grupo de usuarios a su cargo',
                          ];
    }
    else{    
            return $response = [
                'message' => 'Mensajeros del grupo:!',
                'status' => 200,                  
                'data'=>$datos,

        ];
    }

}


 public function actionAceptarechazaenvio($id){
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
    $envio_id = $headers['envio'];
    $aceptacion = $headers['acepto'];

//    print_r($user_id); echo('<br>');
//    print_r($envio_id); echo('<br>'); 
//    print_r($aceptacion);  echo('<br>'); 
//    print_r($headers);  echo('<br>'); 
//    die();
    
     if((empty($user_id)) || empty($envio_id)){
                return $response = [
                        'message' => 'Faltan parametros. Revise el Usuario Id, o el envio_id',
                        'data' => [
                        'status' => 401,
                    ]
                ];
    }
    
    if($aceptacion == 1){        
        \app\models\Envio::updateAll(['mensajero_id' => $user_id], 'id = '. "'".$envio_id."'".' and '. 'modo_envio IN(2,3)');
        return $response = [
                        'message' => 'Envio Aceptado',
                        'data' => [
                        'status' => 200,
                    ]
                ];
    }
    else if($aceptacion == 0){
        \app\models\Envio::updateAll(['mensajero_id' => NULL], 'id = '. "'".$envio_id."'");
        $model=new \app\models\EnviosRechazados;
        $model->envio_id=$envio_id;
        $model->mensajero_id=$user_id;
        $model->fecha = date("Y-m-d H:i"); 
        $model->save();
        return $response = [
                        'message' => 'Envio Rechazado',
                        'data' => [
                        'status' => 200,
                    ]
                ];
        /**********************************************/
//        AQUI SE DEBE ACTUALIZAR PARA VOLVER A ENVIAR DATOS AL CONTROLADOR ENVIO Y CARGAR LOS DATOS DE LOS ENVIOS MENOS LOS RECHAZADOS
        
        
        
        
        /**********************************************/
    }
    else{
         return $response = [
                        'message' => 'No se ha ejecutado ninguna acción',
                        'data' => [
                        'status' => 402,
                    ]
                ];
    }
}



 public function actionNotificaciones($id){
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
    $fecha_hoy = date("Y-m-d");
    
   //Envios creados hoy y con estado 1
    $query_nuevo_envios = \app\models\Envio::find()
            ->where(['estado_envio_id'=>1])
            ->andWhere(['mensajero_id'=>NULL])
            ->andWhere(['fecha_registro'=>$fecha_hoy])
            ->asArray()->all();  
    if(empty($query_nuevo_envios)){
        $query_nuevo_envios =0;
    }    
    
    //Envios pendientes del mensajero para hoy
    $query_envios_hoy = \app\models\Envio::find()
            ->where(['estado_envio_id'=>2])
            ->andWhere(['mensajero_id'=>$user_id])            
            ->andWhere(['fecha_registro'=>$fecha_hoy])
            ->asArray()->all();
    if(empty($query_envios_hoy)){
        $query_envios_hoy =0;
    }
    
    //Envios pendientes en la semana:
    $week = date("W");   
    for($i=0; $i<7; $i++){
        $fechas []= date('Y-m-d', strtotime('01/01 +' . ($week - 1) . ' weeks first day +' . $i . ' day'));
    }
    $fecha_inicio = $fecha_hoy;
    $fecha_final = array_pop($fechas);    
    $query_envios_semana = \app\models\Envio::find()
            ->where(['mensajero_id'=>$user_id])            
            ->andWhere(['estado_envio_id'=>2])
            ->andWhere(['mensajero_id'=>$user_id]) 
            ->andWhere(['between', 'fecha_registro', $fecha_inicio, $fecha_final ])   
            ->asArray()->all();
    if(empty($query_envios_semana)){
        $query_envios_semana =0;
    }
    
     //Envios cancelados hoy
    $query_envios_cancelados_hoy = \app\models\Envio::find()
            ->where(['estado_envio_id'=>4])
            ->andWhere(['mensajero_id'=>$user_id]) 
            ->andWhere(['fecha_registro'=>$fecha_hoy])
            ->asArray()->all();
     if(empty($query_envios_cancelados_hoy)){
        $query_envios_cancelados_hoy =0;
    }
        
      return $response = [
                        'message' => 'Notificaciones:!',
                        'status' => 200,
                        'data' => [
                            
                            [
                                'nombre_notificacion'=>'Envios Creados Hoy',
                                'valor'=>$query_nuevo_envios
                            ],   
                            [
                                'nombre_notificacion'=>'Envios Pendientes Hoy',
                                'valor'=>$query_envios_hoy
                            ], 
                            [
                                'nombre_notificacion'=>'Envios Pendientes de la Semana',
                                'valor'=>$query_envios_semana
                            ],
                            [
                                'nombre_notificacion'=>'Envios Cancelados Hoy',
                                'valor'=>$query_envios_cancelados_hoy
                            ],
                        ],    
//                        'envios_creados_hoy'=>$query_nuevo_envios,   
//                        'envios_pendientes_hoy'=>$query_envios_hoy,   
//                        'envios_pendientes_en_la_semana'=>$query_envios_semana,   
//                        'envios_cancelados_hoy'=>$query_envios_cancelados_hoy,   
                ];
}



 public function actionCambiopassword($id){
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
    $password = $headers['password'];
    if(empty($password)) { 
         return $response = [
                            'status' => 204,
                            'message' => 'No se ha enviado Contraseña para actualizar',
                          ];
    }
    else{
            $haspassword = \Yii::$app->security->generatePasswordHash($password);
            $query = \app\models\User::updateAll(['password' => $haspassword], 'id = '. "'".$user_id."'" );
            if(empty($query)) {       
                            return $response = [
                                    'status' => 204,
                                    'message' => 'Contraseña no actualizada',
                                  ];
            }
            else{    
                            return $response = [
                                'message' => 'Contraseña actualizada con exito!',
                                'status' => 200,
                        ];
            }
    }

}


public function actionComentario($id){
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
    $mensaje = $headers['mensaje'];
    if(empty($user_id)) { 
         return $response = [
                            'status' => 204,
                            'message' => 'No existe el Usuario',
                          ];
    }
    else{
            $perfil = \app\models\Profile::find()->where(['user_id'=>$user_id])->asArray()->one();            
            $consulta_email = \app\models\User::find()->select(['email'])->where(['id'=>$user_id])->asArray()->one();
//            print_r($perfil); die();
            $nombre = $perfil['full_name'];
            $telefono = $perfil['telefono'];
            $ciudad_id = $perfil['ciudad_id'];
            if(empty($ciudad_id)){
                $ciudad_id = 0;
            }
            $tipo_mensaje = "Comentario";
            $email = $consulta_email['email'];
            
            $model= new \app\models\Contactanos;
            $model->nombre = $nombre;
            $model->email = $email;
            $model->telefono = $telefono;
            $model->ciudad_id = $ciudad_id;
            $model->tipo_mensaje = $tipo_mensaje;
            $model->mensaje = $mensaje;
            $model->save();
            if($model->save()) {       
                            return $response = [
                                    'status' => 200,
                                    'message' => 'Mensaje enviado con éxito',
                                  ];
            }
            else{    
                            return $response = [
                                'message' => 'No se pudo enviar el mensaje!',
                                'status' => 204,
                                'detalle'=> $model->getErrors(),
                        ];
            }
    }

}


// public function actionRechazaenvio($id){
//     $user_id = $id;  
//    /******************************************* VALIDACION DE TOKEN *************************************/
//    $headers = Yii::$app->request->headers;
//    $token = $headers['token'];
//    $validacion = \app\modules\api\models\Auth::validatoken($user_id, $token);
//    if((empty($validacion)) || ($validacion=0)){
//                return $response = [
//                        'message' => 'No autorizado',
//                        'data' => [
//                        'status' => 401,
//                    ]
//                ];
//    }
//    /******************************************* FIN VALIDACION DE TOKEN *************************************/ 
//    
//    if(!empty($user_id)){
//         $mensajeros = (new \yii\db\Query())
//        ->select(['t1.id', 't1.user_id', 't1.longitud', 't1.latitud', 't1.fecha'])
//        ->from('tracking t1')
//        ->where('t1.fecha = (SELECT MAX(t2.fecha)FROM tracking t2 WHERE t2.user_id = t1.user_id)')
//        ->andWhere('t1.user_id !='.$user_id)
//        ->all();
//    }
//    //********************************************Algoritmo para seleccionar mensajero en base a distancia y favoritos***************************************/
//        $model = new \app\models\Envio;
//        $algoritmo = $model->algoritmoseleccionmensajero($radio, $mensajeros);
////********************************************Fin Algoritmo para seleccionar mensajero en base a distancia y favoritos***************************************/
//    
//    
//    
//    
// }



// public function actionMatchmensajero($envio_id){   
//    if(!empty($envio_id)){        
//        $key = true;
//        while($key = true){   
//            $query = \app\models\Envio::find()->select(['mensajero_id'])
//                    ->where(['id'=>$envio_id])
//                    ->andWhere(['not',['mensajero_id' => null]])
//                    ->asArray()->one(); 
//            if(!empty($query)){              
//                    $key = false;
//                    return $query['mensajero_id'];
//                    break;
//            }               
//        }         
//    }
//}



}
