<?php
namespace app\modules\api\controllers;
use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;


class TrackingController extends \yii\rest\Controller
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
                    'actions' => ['actualizardestino', 'registrocoordenadas', 'coordenadasruta', 'registrocoordenadas1'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ],
       'authenticator' => [
            'class' => \yii\filters\auth\CompositeAuth::className(),
            'except' => ['actualizardestino', 'registrocoordenadas', 'coordenadasruta', 'registrocoordenadas1'],
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

public function actionActualizardestino($destino_id){
    if(empty($destino_id)){
                return $response = [
                        'message' => 'No existe id destino',
                        'status' => 404,
                ];
    }
    
//    $query_estado = \app\models\Destino::find()->where(['id'=>$destino_id])->andWhere(['estado_envio_id'=>3])->asArray()->one();
//    $estado = $query_estado['estado_envio_id'];
//    if($estado == 3){
//                return $response = [
//                        'message' => 'El destino ya cambio de estado',
//                        'status' => 404,
//                ];
//    }
    
    \app\models\Destino::updateAll(['estado_envio_id' => 3], 'id = '. "'".$destino_id."'" );
    $query = \app\models\Destino::find()->select(['envio_id'])->where(['id'=>$destino_id])->asArray()->one();
    $envio_id = $query['envio_id'];
    $contador_destinos = \app\models\Destino::find()->where(['envio_id'=>$envio_id])->asArray()->count();
    $contador_envios_finalizados = \app\models\Destino::find()->where(['envio_id'=>$envio_id])->andWhere(['estado_envio_id'=>3])->asArray()->count();
    
    if($contador_destinos == $contador_envios_finalizados){
        \app\models\Envio::updateAll(['estado_envio_id' => 3, 'fecha_fin_envio'=>date("Y-m-d H:i")], 'id = '. "'".$envio_id."'" );
        
//        Registro de Pagos en TAbla pagos mensajero
        $query_envio= \app\models\Envio::find()->select(['mensajero_id','valor_total'])->where(['id'=>$envio_id])->asArray()->one();
        $mensajero_id =$query_envio['mensajero_id'];
        $valor =$query_envio['valor_total']; 
//        print_r($envio_id); die();
        
        $query_perfil = \app\models\Profile::find()->select(['id_configuracion_pagos'])->where(['user_id'=>$mensajero_id])->asArray()->one();
        if(empty($query_perfil)){
             return $response = [
                        'message' => 'Mensajero no ha seleccionado tipo de pago o el envio no ha pasado a la etapa 2',
                        'status' => 201,
                ];
         }      
        $id_conf_pagos =$query_perfil['id_configuracion_pagos'];
        $query_configuracion_pagos = \app\models\ConfiguracionPagos::find()
                ->where(['id'=>$id_conf_pagos])->asArray()->one();
        $porcentaje = $query_configuracion_pagos['porcentaje'];
 
        $model= new \app\models\DetallePagos();
        $model->mensajero_id= $mensajero_id;
        $model->envio_id= $envio_id;
        $model->valor= $valor;
        $model->porcentaje= $porcentaje;
        $model->estado= 2;
        $model->fecha = date("Y-m-d H:i");
        $model->save();
        
        /***************************************** PROCEDIMIENTO PARA ALMACENAMIENTO DE PAGOS TABLA HISTORIAL PAGOS ********************************************************************************/
        //1. Multiplico el valor por el porcentaje
        $porcentaje_final = $porcentaje /100;
        $valor_calculo = $valor * $porcentaje_final;
        $valor_historial_pagos = $valor - $valor_calculo;
        
        //2.Registro el valor (menos el porcentaje) en la tabla historial pagos
            //2.1 Busco el registro en la tabla Historial
        $query_historial = \app\models\HistorialPagos::find()->where(['mensajero_id'=>$mensajero_id])->andWhere(['estado'=>2])->asArray()->count();        
            //2.1 Si existe (ESTADO PENDIENTE) lo actualiza - Si no existe lo crea (ESTADO PENDIENTE)
        $model_historial = new \app\models\HistorialPagos;
        if(!empty($query_historial)){
            //2.2 Extraigo ultimo valor en Tabla Historial
            $query_valor_historial = \app\models\HistorialPagos::find()->where(['mensajero_id'=>$mensajero_id])->andWhere(['estado'=>2])->asArray()->one();        
            $ultimo_valor_historial = $query_valor_historial['valor'];
            
            //2.3 Si existe, sumo el valor y actualizo
            $valor_final_historico = $ultimo_valor_historial + $valor_historial_pagos;
            $actualizacion = \app\models\HistorialPagos::updateAll([
                'valor'=>$valor_final_historico,
                'fecha'=>date("Y-m-d H:i"),
//                'estado'=>2], 'mensajero_id = '. "'".$mensajero_id."'", 'estado1 = 4' );
                'estado'=>2], 'mensajero_id = '. "'".$mensajero_id."'".' and '. 'estado  <> 4');
                        
            
//    print_r($actualizacion); die();
            
            if(($actualizacion<>1)){
            return $response = [
                        'message' => 'No se actualizo en HISTORIAL PAGOS',
                        'status' => 201,
                        'error'=>$model->getErrors()
                ];
            }
        }
        else{
        //3. Si no existe historial de pagos lo crea 
                $model_historial->mensajero_id = $mensajero_id;
                $model_historial->valor = $valor_historial_pagos;
                $model_historial->fecha = date("Y-m-d H:i");
                $model_historial->estado = 2;
                $model_historial->save();
        }
        /***************************************** FIN PROCEDIMIENTO PARA ALMACENAMIENTO DE PAGOS TABLA HISTORIAL PAGOS ********************************************************************************/        
//        if($model->save()){
//             return $response = [
//                        'message' => 'Proceso finalizado correctamente',
//                        'status' => 200,
//                ];
//        }
        if(($model->save()) && (isset($actualizacion)) || ($model_historial->save())){
             return $response = [
                        'message' => 'Destinos y envio finalizados correctamente. Pagos realizados sin problema',
                        'status' => 200,
                ];
         }
             else  {
                return $response = [
                        'message' => 'Error al guardar Tabla Detalle pagos',
                        'status' => 201,
                        'error'=>$model->getErrors()
                ];
            }
    }
    else{
                return $response = [
                        'message' => 'Destino finalizado correctamente',
                        'status' => 200,
                ];
    }
}


public function actionRegistrocoordenadas($id){
    date_default_timezone_set('America/Guayaquil');
    $connection = \Yii::$app->db;
    $headers = Yii::$app->request->headers;    
    $user_id = $id;
    $token = $headers['token'];
    $array_ubicaciones = $headers['ubicaciones'];
    /******************************************* VALIDACION DE TOKEN *************************************/
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
   
    $ubicaciones = json_decode($array_ubicaciones, true);
    
    if((empty($user_id)) || (empty($ubicaciones))){
              return $response = [
                'status' => 204,
                'message' => 'Datos vacios!',
              ];
    }
    else{
           /****************************** Almaceno información*******************************/
           
            foreach($ubicaciones as $ub){                  
                foreach($ub as $u){
                    $model=new \app\models\Tracking;
                    $model->user_id = $user_id;
                    $model->longitud = $u['longitud'];
                    $model->latitud = $u['latitud'];
                    $model->fecha = $u['fecha'];
                    $model->save(); 
                } 
            }
           /****************************** Fin Almaceno información*******************************/ 
        if($model->save()){
                return $response = [
                    'status' => 200,
                    'message' => 'Tracking almacenado correctamente',
                ];
        }      
        else{            
              return $response = [
                        'message' => 'Error..Registro no fue almacenado',
                        'status' => 204,
                ];
        }
    }    
}

public function actionRegistrocoordenadas1($id, $latitud, $longitud, $token){
    $user_id = $id;
    $fecha = date("Y-m-d H:i");
    /******************************************* VALIDACION DE TOKEN *************************************/
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
    if((empty($user_id)) || (empty($latitud)) || (empty($longitud))){
              return $response = [
                'status' => 204,
                'message' => 'Datos vacios!',
              ];
    }
    else{
        $model=new \app\models\Tracking;
        $model->user_id= $user_id; 
        $model->latitud= $latitud;
        $model->longitud= $longitud; 
        $model->fecha= $fecha; 
        $model->save();
        if($model->save()){
                return $response = [
                    'status' => 201,
                    'message' => 'Registro de tracking almacenado',
                ];
        }      
        else{            
              return $response = [
                        'message' => 'Error..Registro no fue almacenado',
                        'status' => 204,
                ];
        }
    }    
}


public function actionCoordenadasruta($envio_id){
    if(empty($envio_id)){
                return $response = [
                        'message' => 'No existe id de envio',
                        'status' => 404,
                ];
    }
  else{
           
$query_envio = \app\models\Envio::find()->select(['latitud', 'longitud', 'direccion_origen'])
                ->where(['id'=>$envio_id])->asArray()->one();   
    
$destinos = \app\models\Destino::find()->select(['latitud', 'longitud', 'direccion_destino'])
                ->where(['envio_id'=>$envio_id])->asArray()->all();
  
$latitud_origen = $query_envio['latitud'];
$longitud_origen = $query_envio['longitud'];

//Traigo todos los destinos
 foreach($destinos as $d){   
     $destino_longitud[]=$d['longitud'];
     $destino_latitud[]=$d['latitud'];
 }

$destinos_completos = $destinos;
            if(!empty($destinos_completos)){        
                                        //Extraigo la latitud y longitud del ultimo registro de destinos (que serà DESTINO)
                                        $ultimo_destino = array_pop($destinos);

                                        //Marco la diferencia de los waypoints menos el ultimo array extraido
                                        $resultado_destinos = array_diff_assoc($destinos, $ultimo_destino);

                                        $latitud_destino = $ultimo_destino['latitud'];
                                        $longitud_destino = $ultimo_destino['longitud'];

            //                            echo '<h3>Direcciones</h3>';
                                        $coord = new LatLng(['lat' => $latitud_origen, 'lng' => $longitud_origen]);
                                        $map = new Map([
                                            'center' => $coord,
                                            'zoom' => 15,
                                        ]);

                                        // lets use the directions renderer
                                        $origen = new LatLng(['lat' => $latitud_origen, 'lng' => $longitud_origen]);
                                        $destino = new LatLng(['lat' => $latitud_destino, 'lng' =>$longitud_destino]);

                                        foreach($resultado_destinos as $d){         
                                            $dest = new LatLng(['lat' => $d['latitud'], 'lng' =>$d['longitud']]);    
                                            $resto_destinos[] = new DirectionsWayPoint(['location' => $dest]);
                                        }

                                        if(empty($resto_destinos)){
                                                  // setup just one waypoint (Google allows a max of 8)
                                                $directionsRequest = new DirectionsRequest([
                                                    'origin' => $origen,
                                                    'destination' => $destino,
            //                                        'waypoints' => $resto_destinos,
                                        //            'optimizeWaypoints'=> true,
                                                    'travelMode' => TravelMode::DRIVING
                                                ]);
                                        }
                                        else{
                                                // setup just one waypoint (Google allows a max of 8)
                                                $directionsRequest = new DirectionsRequest([
                                                    'origin' => $origen,
                                                    'destination' => $destino,
                                                    'waypoints' => $resto_destinos,
                                        //            'optimizeWaypoints'=> true,
                                                    'travelMode' => TravelMode::DRIVING
                                                ]);
                                        }
//                                        $vector[]=$directionsRequest;

                                        // Now the renderer
                                        $directionsRenderer = new DirectionsRenderer([
                                            'map' => $map->getName(),
                                        ]);

                                        // Finally the directions service
                                        $directionsService = new DirectionsService([
                                            'directionsRenderer' => $directionsRenderer,
                                            'directionsRequest' => $directionsRequest
                                        ]);
                                        
                                        // Thats it, append the resulting script to the map
                                        $map->appendScript($directionsService->getJs());

                                        
                                        return Json::encode($directionsRequest);
//                                        return ($directionsRequest);
                                        
            }
            else{
                                    //Cuando existe unicamente el origen, se lo grafica a traves de uno solo Marker
                                    echo yii2mod\google\maps\markers\GoogleMaps::widget([
                                        'userLocations' => [
                                            [
                                                'location' => [
                                    //                'address' => 'Shuaras, Quito 170104, Ecuador',
                                                    'lat'=>$latitud_origen,
                                                    'long'=>$longitud_origen
                                    //                'country' => 'Ukraine',
                                                ],
                                                'htmlContent' => '<h1>Origen</h1>',
                                            ],
                                        ],
                                        /**********************************************/
                                        'googleMapsUrlOptions' => [
                                            'key' => 'AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8',
                                            'language' => 'id',
                                            'version' => '3.1.18',
                                        ],
                                        'googleMapsOptions' => [
                                            'mapTypeId' => 'roadmap',
                                            'tilt' => 45,
                                            'zoom' => 5,
                                        ],
                                        /**********************************************/
                                    ]); 
                                    
                                    $resultado =  yii2mod\google\maps\markers\GoogleMaps::widget([
                                        'userLocations' => [
                                            [
                                                'location' => [
                                    //                'address' => 'Shuaras, Quito 170104, Ecuador',
                                                    'lat'=>$latitud_origen,
                                                    'long'=>$longitud_origen
                                    //                'country' => 'Ukraine',
                                                ],
                                                'htmlContent' => '<h1>Origen</h1>',
                                            ],
                                        ],
                                        /**********************************************/
                                        'googleMapsUrlOptions' => [
                                            'key' => 'AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8',
                                            'language' => 'id',
                                            'version' => '3.1.18',
                                        ],
                                        'googleMapsOptions' => [
                                            'mapTypeId' => 'roadmap',
                                            'tilt' => 45,
                                            'zoom' => 5,
                                        ],
                                        /**********************************************/
                                    ]);
                                    
                                        
                                    return ($resultado);     
                                        
            }
}    
    
}





}
