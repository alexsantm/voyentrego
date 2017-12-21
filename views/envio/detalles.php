<?php
use yii\helpers\Html;
use yii\helpers\Url;

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
use kartik\mpdf\Pdf;

use yii\httpclient\Client;
use kartik\widgets\Spinner;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Mensajeros Cercanos';
?>
<div class="seccion_tomate_pasos"><center><span class="numero_pasos">3</span></center></div>
<!--<h2>Detalles de Factura</h2>-->
<div class="row">
    <?php
//    print_r(Yii::$app->request->get()); die();
    $get = Yii::$app->request->get();
        $envio_id = $get['envio_id'];
        $modo_envio = $get['modo_envio'];
        $detalle_distancia_envio=$get['detalle_distancia_envio'];
        $total_km= $get['total_km'];    
        $valor_km= $get['valor_km'];    
    //    $nombre= $get['nombre'];  
    //    $direccion= $get['direccion'];  
    //    $telefono= $get['telefono'];  
    //    $cedula= $get['cedula'];  
    //    $email= $get['email']; 
    //    $valor_recarga= $get['valor_recarga']; 
    //    $ruc_mv= '1792361575001';
        $tiempo_estimado= $get['tiempo_estimado']; 
    
    //Lista de Envios
    if(!empty($get['envios'])){
        $envios= $get['envios']; 
//        print_r($envios); die();
    }
    
//*********************************  ACTUALIZO VALOR DE RECARGA *******************/
    $model_recarga= new app\models\Envio();
    $actualiza_recarga=$model_recarga->actualizarecarga($valor_km);    
//*********************************  FIN ACTUALIZO VALOR DE RECARGA *******************/    
    
//*********************************  LLAMA FUNCION FACTURA *******************/
//$model= new app\models\Factura();
//  $factura = $model->factura($nombre, $telefono, $cedula, $direccion, $email, $valor_km, $total_km, $detalle_distancia_envio);
//  $estado=$factura[0];
//  $ruc_mv=$factura[1];
//  $claveAcceso=$factura[2]; 
//*********************************  FIN LLAMA FUNCION FACTURA *******************/  
?>    
 </div>    
<?php
if($modo_envio ==1)
{          
?>                 
                  <div class="row">
                  <h2>Mensajeros Cercanos</h2>
                  <?php
//                  Html::a( '<i class="glyphicon glyphicon-barcode"></i> Descargar Factura',
//                                                          ['/envio/factura', 
//                                                              //Datos para Factura:
//                                                              'detalle_distancia_envio'=>$detalle_distancia_envio,
//                                                              'total_km'=>$total_km,
//                                                              'valor_km'=>$valor_km, 
//                                                              'nombre'=>$nombre, 
//                                                              'direccion'=>$direccion, 
//                                                              'telefono'=>$telefono, 
//                                                              'cedula'=>$cedula, 
//                                                              'email'=>$email, 
//                                                              'valor_recarga'=>$valor_recarga,
//
//                                                              'detalle_distancia_envio'=>$detalle_distancia_envio,
//
//                                                              'ruc_mv'=>$ruc_mv,
//                                                              'clave_acceso'=>$claveAcceso,
//                  //                                            'autorizacion'=>$document->auth_code,
//                                                          ],    
//                                                              [
//                                                                  'class'=>'btn btn-danger btn-lg', 
//                                                                  'target'=>'_blank', 
//                                                                  'data-toggle'=>'tooltip', 
//                                                                  'title'=>'Descargue su Factura'
//                                                              ]
//                                                          );
                  ?>
                  </div>

                  <h4>A continuación se muestran los mensajeros cercanos al Punto de Origen, y el mensajero asignado para realizar su envío</h4>
                  <h4>Si tiene un mensajero asignado como <strong>"Favorito"</strong>, tendrá la prioridad</h4><br>

                  <div class="row">
                      <div class="col-lg-6">
                                  <?php
                                  $coord_centro = new LatLng(['lat' => $latitud_origen, 'lng' => $longitud_origen]);
                                  $map = new Map([
                                      'center' => $coord_centro,
                                      'zoom' => 13,
                                      'width' => '100%'
                                  ]);
                                  $marker_centro = new Marker([
                                      'position' => $coord_centro, 
                                      'title' => 'Origen',
                                      'animation' => 'google.maps.Animation.DROP',
                                      'icon' => \yii\helpers\Url::base().'/images/markers/origen.png',
                                      ]);

                                  $marker_centro->attachInfoWindow(new InfoWindow(['content' => 'Origen']));

                                  $circle = new \dosamigos\google\maps\overlays\Circle([
                                      'center' => $coord_centro, 
                                      'radius' => $radio,  //En metros desde la tabla OPCIONES
                                      'strokeColor' => '#2196F3', 
                                      'strokeWeight' => 1, 
                                      'fillOpacity' => 0.08
                                  ]);
                                  $marker_centro->attachInfoWindow(new InfoWindow(
                                          ['content' => "<h4><strong>Origen</strong></h4>"
                                          ]));        
                                  $map->addOverlay($marker_centro);

                                  foreach ($mensajeros as $f) {
                                      $coord = new LatLng(['lat' => $f['latitud'], 'lng' => $f['longitud']]);
                                      $aux = \app\models\Profile::find()->where(['user_id'=>$f['user_id']])->asArray()->one();
                                      $full_name = $aux['full_name'];
                                     
                                      //Estraigo status y seteo el icono de la tabla StatusMensajero
                                      $query = \amnah\yii2\user\models\User::find()->where(['id'=>$f['user_id']])->asArray()->one();
                                      $status = $query['status_id'];
                                      $quey_status = app\models\StatusMensajero::find()->where(['id'=>$status])->asArray()->one();
                                      $icono_status = $quey_status['icono'];
                                          
                                      $marker = new Marker([
                                                  'position' => $coord,
                                                  'title' => $full_name,
                                                  'animation' => 'google.maps.Animation.DROP',
                                                  'visible'=>'true',
                                                  'icon'=>\yii\helpers\Url::base().'/images/markers/estados_mensajeros/'.$icono_status,
                                              ]);

                                      if(empty($full_name)){
                                          $marker->attachInfoWindow(new InfoWindow(['content' => "Sin nombre registrado" ])); 
                                      }
                                      else{
                                          $marker->attachInfoWindow(new InfoWindow(['content' => $full_name ]));  
                                      }        
                                       $map->addOverlay($marker);     
                                  }    
                                  $map->addOverlay($circle);
                                  echo $map->display();
                                  ?>
                  </div>        

                      <div class="col-lg-6">
                              <?php
                  //********************************************Algoritmo para seleccionar mensajero en base a distancia y favoritos***************************************/        
                              $model = new \app\models\Envio;
                              //$algoritmo = $model->algoritmoseleccionmensajero($radio, $envio_id, $mensajeros, $latitud_origen, $longitud_origen, $total_km,  $valor_km, $tiempo_estimado);                              
                              $algoritmo = $model->algoritmoseleccionmensajero($radio, $envio_id, $mensajeros_disponibles, $latitud_origen, $longitud_origen, $total_km,  $valor_km, $tiempo_estimado);
//                              if(!empty($envios)){
//                              $algoritmo = $model->algoritmoseleccionmensajerorecurrente($radio, $envio_id, $mensajeros, $latitud_origen, $longitud_origen, $total_km,  $valor_km, $tiempo_estimado, $envios);    
//                              }
//                              else{
//                              $algoritmo = $model->algoritmoseleccionmensajero($radio, $envio_id, $mensajeros, $latitud_origen, $longitud_origen, $total_km,  $valor_km, $tiempo_estimado);
//                              }
                  //********************************************Fin Algoritmo para seleccionar mensajero en base a distancia y favoritos***************************************/
                              ?>
                     </div> 
                </div>
<?php
} //Fin de modo envio = 1
else if (($modo_envio ==2) || ($modo_envio ==3)){ 
    
            //************** Registro Km, valor y tiempo estimado dependiendo del modo de envio**************
                    $model = new app\models\Envio;    
                    if($modo_envio==2){
                        $registrokm = $model->registrokm($envio_id, $total_km, $valor_km, $tiempo_estimado);
                    }
                    //else if (($modo_envio==3) && (!empty($envios))){
                    else if (($modo_envio==3) && !empty($envios)){
//                        print_r("ebntre"); die();
                        $registrokmrecurrente = $model->registrokmrecurrente($envio_id, $total_km, $valor_km, $tiempo_estimado, $envios);
                    }
                    else{
                        print_r("Error al registrar Km para modo de envio inexistentes");
                        die();
                    }
            //************** Fin Registro Km, valor y tiempo estimado dependiendo del modo de envio**************        
   
    ?>
    <div class="row">  
        <br>
        <div class="panel panel-success">
                <div class="panel-heading"> <center><h2>Su Envío ha sido procesado con éxito</h2></center></div>
                <div class="panel-body"> 
                        <h3>Detalles:</h3>
                        <li>Su envío fue generado y almacenado con éxito</li>
                        <li>En un momento, un mensajero tomará su envío</li>
                        <li>El mensajero que tome su pedido, completará la ruta y notificará la culminación de cada Destino</li>
                        <li>Una vez que todos los destinos hayan sido completados, el envío total será finalizado</li>
                        
<!--                                  <div class="row"> 
                                      <div class="col-lg-6 col-lg-offset-3">
                                            <?php
//                                              for ($tries = 0; $tries < 2500; ++$tries) {
//                                        //                          $lock = $this->is_enabled('cache-lock');
//                                                                  $lock = \app\models\Envio::find()->select(['mensajero_id'])
//                                                                            ->where(['id'=>$envio_id])
//                                                                            ->andWhere(['not',['mensajero_id' => null]])
//                                                                            ->asArray()->one(); 
//
//                                                                  if ($lock) {  // Lock acquired everything is good
//                                                                      return;
//                                                                  } else if ($tries + 1 == 2500) {  // maximum tries reached: ERROR
//                                                                      // the following method is a short cut for throwing an exception.
//                                                                            echo '<div class="well"><center><h2>Buscando Mensajero</h2></center>';
//                                                                                echo Spinner::widget([
//                                                                                    'preset' => 'large', 
//                                                                                    'align' => 'center',
//                                                                                    'color' => '#5CB85C']);
//                                                                                echo '<div class="clearfix"></div>';
//                                                                            echo '</div>';
//                                                                  } 
//                                        //                          else {  // Wait one second to reduce server-workload
//                                        //                              sleep(1);
//                                        //                          }
//                                            }
                                            ?>                  
                                        </div> 
                                  </div>-->
                        
                        <li>Puede consultar el estado de su envio haciendo click en el siguiente botón</li><br>
                        <center><?= Html::a('Ir a Historico de Envios',['/envio/index#proceso'],['class' => 'btn btn-danger btn-lg']);?></center>   
                </div>
        </div>        
          
    </div>
                     
<?php    
}
?>              
<style>
    .well {
        background-color: transparent !important; 
        border: 0px !important; 
    }
    
    
    #gmap0-map-canvas{
        height: 340px !important;
    }
    
    .row {
        margin-right: 0 !important;
        margin-left: 0 !important;
    }
    
    .alert a {    
    text-decoration: none;
}
</style>