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

/* @var $this yii\web\View */
/* @var $model app\models\Envio */

//$this->title = $model->id;
$this->title = $model->direccion_origen;
$envio_id =$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



        /*****************************************************************/
//        Traigo las fechas y los id de los registros para ingresarlos en cada destino
            $get=Yii::$app->request->get(); 
            $fechas=$get['fechas'];
            $array_id=$get['array_id'];

?>
<div class="envio-view">

    <div class="row">
        <div class="col-lg-10">
            <h1><?php echo('Detalle del envío: '); ?><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-lg-2"><br>
            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
    
    <?php 
//    DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'ciudad_id',
////            'user_id',
//            'remitente',
//            'direccion_origen',
////            'latitud',
////            'longitud',
////            'celular',
////            'fecha_registro',
////            'fecha_fin_envio',
////            'total_km',
////            'valor_total',
////            'observacion',
////            'estado_envio_id',
////            'tipo_envio_id',
////            'dimensiones_id',
////            'mensajero_id',
//        ],
//    ]) 
            ?>

</div>

<!--/*********************************************************************************************************************/-->
<?php
$latitud_origen = $model['latitud'];
$longitud_origen = $model['longitud'];

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
                            $coord = new LatLng(['lat' => $latitud_origen, 'lng' => $latitud_origen]);
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

                            // Lets show the BicyclingLayer :)
                            $bikeLayer = new BicyclingLayer(['map' => $map->getName()]);

                            // Append its resulting script
                            $map->appendScript($bikeLayer->getJs());

                            // Display the map -finally :)
                            echo $map->display(); 
}
else{
                        //Cuando existe unicamente el destino, se lo grafica a traves de uno solo Marker
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
}
?>

<!--/*****************************************************GRIDVIEW DE  DESTINOS**************************************************************/-->
<div class="geo-destino-index">
    <br><br>
    <p> <?= Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>Nuevo Destino Recurrente',
            ['destino/createrec',
                'id'=>$model->id,
                'fechas'=>$fechas,
                'array_id'=>$array_id
            ],
            ['class'=>'btn btn-success btn-lg modalButton', 'title'=>'view/edit', ]
            );?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
     'dataProvider' => $dataProvider,
     'panel' => ['type' => GridView::TYPE_WARNING, 'footer'=>false],
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label' => 'Id',
                'hAlign'=>'center',
                'vAlign'=>'middle',
            ], 
            [
                'attribute' => 'ciudad_id',
                'label' => 'Ciudad',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value' => function($model, $key, $index, $column) {
                   $service = app\models\Ciudad::findOne($model->ciudad_id);
                   return $service ? $service->ciudad : '-';
                },     
            ],
            [
                'attribute' => 'destinatario',
                'label' => 'Destinatario',
                'hAlign'=>'center',
                'vAlign'=>'middle',
            ],             
            [
                'attribute' => 'direccion_destino',
                'label' => 'Dirección Destino',
                'hAlign'=>'center',
                'vAlign'=>'middle',
            ],             
//            'latitud',
//            'longitud',
            [
                'attribute' => 'celular',
                'label' => 'Celular',
                'hAlign'=>'center',
                'vAlign'=>'middle',
            ],             
            [
                'attribute' => 'fecha_registro',
                'label' => 'Fecha Registro',
                'hAlign'=>'center',
                'vAlign'=>'middle',
            ],             
//            'fecha_asignacion',
//            'fecha_finalizacion',
//            'kilometros',
//            'valor',
            [
                'attribute' => 'observacion',
                'label' => 'Observación',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'format'=>'html'
            ],             
//            'estado_envio_id',
            [
                'attribute' => 'retorno_destino_id',
                'label' => 'Retorno a:',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value' => function($model, $key, $index, $column) {
                   $service = app\models\Destino::findOne($model->retorno_destino_id);
                   return $service ? $service->direccion_destino : '-';
                },     
            ],            
            [
                'attribute' => 'retorno_inicio',
                'label' => 'Retorno a Origen:',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value' => function($model, $key, $index, $column) {
                   if($model->retorno_inicio){
                       return "Si";
                   } 
                   else{
                       return "No";
                   }                   
                },     
            ],            
//            'tipo_envio_id',
//            'dimensiones_id',
//            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'kartik\grid\ActionColumn',
              'template'=>'{view}{update}{delete}',
                'buttons'=>[
                        'view' => function ($url, $model) { 
                            $url = Yii::$app->urlManager->createAbsoluteUrl(['destino/'.$model->id]);
//                            print_r($url);
//                            print_r(Yii::$app->urlManager->createAbsoluteUrl(['destino/'.$model->id]));
//                            die();
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
                                  'class'=>'btn btn-success btn-md modalButton','title' => Yii::t('yii', 'View'),
                          ]); 
                        },
                        'update' => function ($url, $model) {     
                        $url = Yii::$app->urlManager->createAbsoluteUrl(['destino/update/'.$model->id,  'id_envio' => $model->envio_id]);    
                        return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                                  'class'=>'btn btn-success btn-md','title' => Yii::t('yii', 'Update'),
                          ]); 
                        },
                        'delete' => function($url, $model) {
                        $url = Yii::$app->urlManager->createAbsoluteUrl(['destino/'.$model->id]);    
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], ['class'=>'btn btn-success btn-md',
                        'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);        
                        }        
                ]                                      
            ],           
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<!--/******************************************************FIN GRIDVIEW DE DESTINOS************************************************************/-->
<?php
                                        /***********************************************************/
                                        //*****************Calculo de Distancias******************
                                        /************************************************************/
if(!empty($destinos_completos)){ //Unicamente funciona cuando existe solo un inicio

//    print_r("destinos_llenos");
                    $primer_punto[] = [$destinos_completos[0]['latitud'] , $destinos_completos[0]['longitud']];

                        $total_distancias=0;
                        foreach($primer_punto as $pp){
                    //        print_r($pp);
                            $lat_primer_punto = $pp[0];
                            $long_primer_punto = $pp[1];
                        }

                    //Distancia desde origen hasta primer punto
                    $latlng_origin        = [$latitud_origen,$longitud_origen];
                    $latlng_destination   = [$lat_primer_punto,$long_primer_punto];

                    $dist_origen_primer_punto = $model->calculo_distancia($latitud_origen, $longitud_origen, $lat_primer_punto, $long_primer_punto);
                    echo('<h2>'); echo('Distancia Origen al primer punto:');echo(round($dist_origen_primer_punto, 2));echo('</h2>');  

                     //Distancia entre puntos:   
                        $unit = 'km'; // 'miles' or 'km'
                        $punto[] = [$destinos_completos[0]['latitud'] , $destinos_completos[0]['longitud']];
                        $lugar[] = [$destinos_completos[0]['direccion_destino']];
                        $dist_resto_puntos=0;
                        for($i = 0; $i<count($destinos_completos); $i++){          
                                    $punto[] = [$destinos_completos[$i]['latitud'] , $destinos_completos[$i]['longitud']];
                                    $lugar[] = [$destinos_completos[$i]['direccion_destino']];
                                    $distance = \Yii::$app->googleApi->getDistance($punto[$i], $punto[$i+1], $unit);
                                    if(is_nan($distance)){
                                        $dist_resto_puntos ==0;
                                    }else{
                                    print_r($lugar[$i][0]); echo(' - '); print_r($lugar[$i+1][0]);; echo("Distancia: ".$distance);echo('<br>');
                                    }
                                    $dist_resto_puntos = $dist_resto_puntos +$distance;echo('<br>');                
                        }
                        if(is_nan($dist_resto_puntos)){
                            $dist_resto_puntos ==0;
                        }
                        else{
                            echo('<h2>'); echo('Distancia resto de puntos:');echo($dist_resto_puntos);echo('</h2>');
                        }

                    //Calculo de retornos entre puntos
                        $resultados = \app\models\Destino::find()->where(['!=', 'retorno_destino_id', 0])->andWhere(['envio_id'=>$model->id])->asArray()->all();
                        $valor_distancia_retornos = 0;
                        if(!empty($resultados)){
                                    foreach($resultados as $r){
                                            $id_retorno_origen = $r['id'];
                                            $id_retorno_destino = $r['retorno_destino_id'];

                                    $coord_orig = \app\models\Destino::find()->select(['latitud', 'longitud'])->where(['id'=> $id_retorno_origen])->one();
                                        $lat_orig=$coord_orig['latitud'];    
                                        $long_orig=$coord_orig['longitud'];    
                                        $lugar_orig=$coord_orig['direccion_destino']; 

                                    $coord_dest = \app\models\Destino::find()->select(['latitud', 'longitud'])->where(['id'=> $id_retorno_destino])->one();
                                        $lat_dest= $coord_dest['latitud'];    
                                        $long_dest= $coord_dest['longitud'];    
                                        $lugar_dest=$coord_dest['direccion_destino']; 

                                    $valor_distancia_ret = $model->calculo_distancia($lat_orig, $long_orig, $lat_dest, $long_dest);
                                    $valor_distancia_retornos = $valor_distancia_retornos + $valor_distancia_ret;

                                    echo('<br>'); echo("<h3>Retornos : ". $valor_distancia_ret.'</h3>' );   
                                   } 
                                   echo('<br>'); echo("<h2>Valor de retornos es: ". $valor_distancia_retornos.'</h2>' );   
                        }
                        else{
                                    $valor_distancia_retornos = 0;
                                    print_r("no hay retornos");
                        }

                    //Calculo de retornos al inicio
                        $resultados = \app\models\Destino::find()->where(['retorno_inicio'=> 1])->andWhere(['envio_id'=>$model->id])->asArray()->all();
                        $valor_distancia_retorno_inicio = 0;
                        print_r($resultados);
                        if(!empty($resultados)){
                                    foreach($resultados as $r){
                                        //  $latitud_origen  coordenada de inicio
                                        //  $longitud_origen coordenada de inicio

                                    $coord_dest = \app\models\GeoDestino::find()->select(['latitud', 'longitud'])->where(['id'=> $id_retorno_destino])->one();
                                        $lat_dest= $coord_dest['latitud'];    
                                        $long_dest= $coord_dest['longitud'];    
                                        $lugar_dest=$coord_dest['direccion_destino']; 

                                    $valor_distancia_ret_ini = $model->calculo_distancia($latitud_origen, $longitud_origen, $lat_dest, $long_dest);
                                    $valor_distancia_retorno_inicio = $valor_distancia_retorno_inicio + $valor_distancia_ret_ini;

                                    echo('<br>'); echo("<h3>Retorno al inicio : ". $valor_distancia_ret_ini.'</h3>' );   
                                   } 
                                   echo('<br>'); echo("<h2>Valor de retornos del inicio: ". $valor_distancia_retorno_inicio.'</h2>' );   
                        }
                        else{
                                    $valor_distancia_retorno_inicio = 0;
                                    print_r("no hay retorno al inicio");
                        }

                     //Distancia sumada de los 2 primeros puntos + el resto 
                        if(is_nan($dist_resto_puntos)){
                            $total = $dist_origen_primer_punto + $valor_distancia_retornos+ $valor_distancia_retorno_inicio;
                        }
                        else{
                            $total = $dist_resto_puntos + $dist_origen_primer_punto + $valor_distancia_retornos+ $valor_distancia_retorno_inicio;
                        }
                        echo('<h2>'); echo('Distancia Total: ');echo($total);echo('</h2>');

                        $valor_km = $model->calculo_valores($total);
                        echo('<br>'); echo("<h2>el valor a cobrar es: ". $valor_km.'</h2>' );
}    
 //*****************Fin Calculo de Distancias******************
?>
<style>
    #gmap0-map-canvas{
        width: 100% !important;
    }
    
/**/Colocar estas lineas para que el input search de google funcione  
/*https://stackoverflow.com/questions/10957781/google-maps-autocomplete-result-in-bootstrap-modal-dialog*/
.pac-container {
    background-color: #FFF;
    z-index: 20;
    position: fixed;
    display: inline-block;
    float: left;
}
.modal{
    z-index: 20;   
}
.modal-backdrop{
    z-index: 10;        
}​

.modal-content{
    width: 125% !important;
}

.kv-panel-before, .kv-panel-after {
    display:none;
}
</style>    
 
<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-lg',
		'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">Cerrar</a>',
    ]);
        echo "<div class='modalContent'></div>";
    yii\bootstrap\Modal::end();

        $this->registerJs(
        "$(document).on('ready pjax:success', function() {
                $('.modalButton').click(function(e){
                   e.preventDefault(); //for prevent default behavior of <a> tag.
                   var tagname = $(this)[0].tagName;
                   $('#editModalId').modal('show').find('.modalContent').load($(this).attr('href'));
               });
            });
        ");
?>

