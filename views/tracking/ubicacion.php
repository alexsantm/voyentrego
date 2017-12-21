<?php
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
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<h3>Mensajeros</h3>';
$this->title = 'Ubicación de Mensajeros';
echo("<p>A continuación se presentan todos los mensajeros con su respectivo status</p>");

Pjax::begin(['id' => 'myPjax']);
//$coord = new LatLng(['lat' => $latitud_origen, 'lng' => $longitud_origen]);
//$coord = new LatLng(['lat' => -1.831239, 'lng' => -78.18340599999999]);
$coord = new LatLng(['lat' => -0.19928890, 'lng' => -78.50644730]);
$map = new Map([
    'center' => $coord,
    'zoom' => 13,
    'width' => '100%',
    'containerOptions' => [
        'id' => 'mapa'
    ]
]);

foreach ($mensajeros as $f) {
    $query = \app\models\Profile::find()->select(['full_name', 'foto'])->where(['user_id'=>$f['user_id']])->asArray()->one();
    $full_name = $query['full_name'];
    $foto = $query['foto'];
    
        if(empty($foto)){
            $foto = Yii::$app->request->BaseUrl.'/images/fotos/default.jpg';
        }else{
            $foto = Yii::$app->request->BaseUrl.'/images/fotos/'.$foto;
        }
        
        
    $coord = new LatLng(['lat' => $f['latitud'], 'lng' => $f['longitud']]);
    
    //Estraigo status y seteo el icono de la tabla StatusMensajero
  $query = \amnah\yii2\user\models\User::find()->where(['id'=>$f['user_id']])->asArray()->one();
  $status = $query['status_id'];
  $quey_status = app\models\StatusMensajero::find()->where(['id'=>$status])->asArray()->one();
  $icono_status = $quey_status['icono'];
  
     $html = '
        <div class="container" style="width:100%;">
            <div class="row">
                <div class="col-sm-12"><center><img src="'.$foto.'" width="50" height="50" /><br><h5>'.$full_name.'</h5></div></center>
            </div>
        </div>
    ';
  
    $marker = new Marker([
                'position' => $coord,
                'title' => $full_name,
                'animation' => 'google.maps.Animation.DROP',
                'visible'=>'true',
                'icon'=>\yii\helpers\Url::base().'/images/markers/estados_mensajeros/'.$icono_status,
            ]);
     //$marker->attachInfoWindow(new InfoWindow(['content' => $full_name]));
     $marker->attachInfoWindow(new InfoWindow(['content' => $html]));
     $map->addOverlay($marker);
}    
echo $map->display();

Pjax::end();

$script = <<< JS
$(mapa).ready(function() {
    setInterval(function() {     
      $.pjax.reload({container:'#myPjax'});
    }, $tiempo_refresco); 
});
JS;
$this->registerJs($script);