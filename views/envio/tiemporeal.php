<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title ="Envío en Tiempo Real";
?>
<h1>Ubicación de Ruta y Mensajero en Tiempo Real</h1>

<?php
$envio_id = Yii::$app->request->get('envio_id');	
$mensajero_id = Yii::$app->request->get('mensajero_id');
$query_origen = \app\models\Envio::find()->select(['latitud', 'longitud'])->where(['id'=>$envio_id])->asArray()->one();
$query_destinos = \app\models\Destino::find()->select(['latitud', 'longitud'])->where(['envio_id'=>$envio_id])->asArray()->all();
$query_tracking = \app\models\Tracking::find()->select(['latitud', 'longitud'])
        ->where(['user_id'=>$mensajero_id])
        ->orderBy('fecha desc')
        ->limit(1)
        ->asArray()->one();
$query = \app\models\Profile::find()->select(['full_name'])->where(['user_id' => $mensajero_id])->asArray()->one();
$full_name = $query['full_name'];

$latitud_origen = $query_origen['latitud'];
$longitud_origen = $query_origen['longitud'];

//Traigo todos los destinos
 foreach($query_destinos as $d){   
     $destino_longitud[]=$d['longitud'];
     $destino_latitud[]=$d['latitud'];
 }
Pjax::begin(['id' => 'myPjax']);
$destinos_completos = $query_destinos;
if(!empty($destinos_completos)){        
                            //Extraigo la latitud y longitud del ultimo registro de destinos (que serà DESTINO)
                            $ultimo_destino = array_pop($query_destinos);

                            //Marco la diferencia de los waypoints menos el ultimo array extraido
                            $resultado_destinos = array_diff_assoc($query_destinos, $ultimo_destino);

                            $latitud_destino = $ultimo_destino['latitud'];
                            $longitud_destino = $ultimo_destino['longitud'];

//                            echo '<h3>Direcciones</h3>';
                            $coord = new LatLng(['lat' => $latitud_origen, 'lng' => $longitud_origen]);
                            $map = new Map([
                                'center' => $coord,
                                'zoom' => 9,
                                'containerOptions' => [
                                    'id' => 'mapa'
                                ]
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
                                        'travelMode' => TravelMode::DRIVING,
//                                        'provideRouteAlternatives'=> true
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
                            
                            //Otra manera de dibujar el camino entre waypoints
//                            $polylineOptions = new PolylineOptions([
//                                'strokeColor' => '#FFAA00',
//                                'strokeOpacity' => 3.0,
//                                'strokeWeight' => 2,
//                                'draggable' => true,
//                                'geodesic' => true,
//                            ]);

                            // Now the renderer
                            $directionsRenderer = new DirectionsRenderer([
                                'map' => $map->getName(),
//                                'polylineOptions' => $polylineOptions
                            ]);
                                                      
                            // Finally the directions service
                            $directionsService = new DirectionsService([
                                'directionsRenderer' => $directionsRenderer,
                                'directionsRequest' => $directionsRequest
                            ]);
                                                        
                           /************************UBICACION DEL MENSAJERO EN EL MAPA*********************/
                                $coord = new LatLng(['lat' => $query_tracking['latitud'], 'lng' => $query_tracking['longitud']]);
                                $marker = new Marker([
                                    'position' => $coord,
                                    'title' => $full_name,
                                    'animation' => 'google.maps.Animation.DROP',
                                    'visible' => 'true',
                                    'animation' => 'google.maps.Animation.DROP',
                                    'icon' => \yii\helpers\Url::base().'/images/markers/mensajero.png',
                                ]);
                                $marker->attachInfoWindow(new InfoWindow(['content' => $full_name]));
                                $map->addOverlay($marker);  
                            /************************FIN UBICACION DEL MENSAJERO EN EL MAPA*********************/

                            // Thats it, append the resulting script to the map
                            $map->appendScript($directionsService->getJs());

                            // Lets show the BicyclingLayer :)
                            $bikeLayer = new BicyclingLayer(['map' => $map->getName()]);

                            // Append its resulting script
                            $map->appendScript($bikeLayer->getJs());                           

                            // Display the map -finally :)
                            echo $map->display(); 
}

Pjax::end();
$script = <<< JS
$(mapa).ready(function() {
    setInterval(function() {     
      $.pjax.reload({container:'#myPjax'});
    }, $tiempo_refresco); 
});
JS;
$this->registerJs($script);
?>

<style>
    #gmap0-map-canvas{
        width: 100% !important;
    }
    #mapa{
        width: 100% !important;
        /*border: solid 2px green;*/
    }

</style>