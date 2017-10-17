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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Mensajeros Cercanos';
?>

<h2>Detalles de Factura</h2>
<div class="row">
    <?php
    print_r(Yii::$app->request->get());
    $get = Yii::$app->request->get();
    
    $detalle_distancia_envio=$get['detalle_distancia_envio'];
    $total_km= $get['total_km'];    
    $valor_km= $get['valor_km'];    
    $nombre= $get['nombre'];  
    $direccion= $get['direccion'];  
    $telefono= $get['telefono'];  
    $cedula= $get['cedula'];  
    $email= $get['email']; 
    $valor_recarga= $get['valor_recarga']; 
    
    
    echo('<br>'); echo('**************************'); echo('<br>');
    echo ("Detalle Distancia Envio : "); echo($detalle_distancia_envio); echo('<br>');
    echo ("total km: "); echo($total_km); echo('<br>');
    echo ("valor km: "); echo($valor_km); echo('<br>');
    echo ("Nombre "); echo($nombre); echo('<br>');
    echo ("Direccion: "); echo($direccion); echo('<br>');
    echo ("Telefono: "); echo($telefono); echo('<br>');
    echo ("cedula: "); echo($cedula); echo('<br>');
    echo ("Email: "); echo($email); echo('<br>');
    echo ("Valor Recarga: "); echo($valor_recarga); echo('<br>');
    


//$client = new Client();
//$response = $client->createRequest()
//        ->setMethod('post')
//        ->setUrl('https://dog.ceo/dog-api/api/breeds/list/all')
//        ->setData(['name' => 'John Doe', 'email' => 'johndoe@example.com'])
//        ->send();
//if ($response->isOk) {
//    $newUserId = $response->data['id'];
//}
//else{
//    print_r("paso algo");
//}
//
//$client = new Client(['baseUrl' => 'https://dog.ceo/api/breeds/list/all']);
//$response = $client->get('https://dog.ceo/api/breeds/list/all');
//print_r($response);


//$text = Yii::$app->httpclient->get('https://dog.ceo/dog-api/api/breeds/list/all');
//foreach($text as $t){
//    print_r($t);
//    //print_r($t['id']); echo("--"); print_r($t['name']); echo("<br>");
//}


?>
</div>



<h2>Mensajeros Cercanos</h2>

<?php
echo Html::a('<i class="glyphicon glyphicon-barcode"></i> Generar Factura', ['/envio/factura'], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Descargue su Factura'
]);

?>

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
    $marker = new Marker([
                'position' => $coord,
//                'title' => 'Mensajero: '.$f['user_id'],
                'title' => $full_name,
                'animation' => 'google.maps.Animation.DROP',
                'visible'=>'true'
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


<?php
//********************************************Calculo de distancias entre el origen y los mensajeros***************************************/
        $model = new \app\models\Envio;
        $radio_en_km = $radio /1000;
        $id_usuario = Yii::$app->user->identity['id'];
        $favorito = \app\models\Favoritos::find()->select('mensajero_id')->asArray()->all();
               
        foreach($favorito as $fav){
            $favorito_id = $fav['mensajero_id'];                
                foreach ($mensajeros as $f) {
                    $latitud_destino = $f['latitud'];
                    $longitud_destino = $f['longitud'];   
                    $mensajero_id =$f['user_id'];                    

                    $valor_distancia = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_destino, $longitud_destino);
//                    $valor_distancia1[] = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_destino, $longitud_destino);

                    if(($valor_distancia < $radio_en_km)){
                        if($mensajero_id == $favorito_id){
//                            echo('Mensajero favorito: '); print_r($mensajero_id); echo('<br>');
                            $mensajero = $model->detallesMensajero($mensajero_id);  
                            echo($mensajero);
                            return;
                        }
                        if($mensajero_id != $favorito_id){
//                            echo('Mensajero: '); print_r($mensajero_id); echo('<br>');
                            $mensajero = $model->detallesMensajero($mensajero_id);  
                            echo($mensajero);
                            return;
                        }
                    }
                    else{   
                        //Guardo los datos en la tabla temporal
                        $connection = Yii::$app->getDb();
                                     $command = $connection->createCommand('                                   
                                     INSERT INTO distancia_temp(mensajero_id, km)
                                     values ('.$mensajero_id.', '.$valor_distancia.')
                                     ');                   
                                     $resultado = $command->execute(); 
                          //Extraigo el valor minimo de la distancia           
                         $valor_minimo = \app\models\DistanciaTemp::find()->select(['mensajero_id'])->min('km');
                         
                         //busco el id del mensajero
                         $id_mjs = \app\models\DistanciaTemp::find()->select('mensajero_id')->where(['km'=>$valor_minimo])->asArray()->one();
                         $id_mensajero = $id_mjs['mensajero_id'];
                                     
                         $mensajero = $model->detallesMensajero($id_mensajero);  
                    }
                }
       }        
       if($mensajero){
                             echo($mensajero);
                             //Elimino los datos de la tabla temporal                                                 
                                     $x = Yii::$app->db->createCommand("
                                        DELETE FROM distancia_temp 
                                    ")->execute();
                             return;        
                         }
?>



<style>
    #gmap0-map-canvas{
        height: 768px !important;
    }

</style>

