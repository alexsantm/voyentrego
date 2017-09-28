<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
<script>
$(window).load(function () {
$('#cargando').hide();
});
</script>
<style type="text/css">
#cargando {
width:350px;
height:70px;
clear:both;
background-color:#FFFF00;
color:#CC0000;
}
</style>
<div id="cargando"><h3>Cargando página ...</h3> Sea paciente, los datos demoran en ser importados.</div>-->

<!--<div class="preload"><img src="http://i.imgur.com/KUJoe.gif">
</div>
<div class="content">I would like to display a loading bar before the entire page is loaded. For now, I'm just using a small delay:

The page already uses jquery.

Note: I have tried this, but it didn't work for me:

loading bar while script runs

I also tried other solutions. In most cases, the page loads as usually or the page won't load/display at all.

Thank you for any help.</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(function() {
    $(".preload").fadeOut(2000, function() {
        $(".content").fadeIn(1000);        
    });
});
</script>    

<style>
.content {display:none;}
.preload { width:100px;
    height: 100px;
    position: fixed;
    top: 50%;
    left: 50%;}
</style>-->


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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Mensajeros Cercanos';
?>







<h2>Mensajeros Cercanos</h2>
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
     $marker->attachInfoWindow(new InfoWindow(['content' => $full_name ]));
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
//        
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
                         echo($mensajero);
                         
                         //Elimino los datos de la tabla temporal                                                 
                                     $x = Yii::$app->db->createCommand("
                                        DELETE FROM distancia_temp 
                                    ")->execute();
                        return;
                    }
                }
       }            
?>

<style>
    #gmap0-map-canvas{
        height: 768px !important;
    }

</style>

