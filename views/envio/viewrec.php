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
//$this->title = $model->id;
$envio_id =$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$flag_programado = Yii::$app->request->get('prog');
//print_r($flag_programado); die();

?>
<div class="envio-view">
    <div class="row">
        <div class="col-lg-10">
            <h1><?php echo('Detalle del envío: '); ?><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-lg-2"><br>
            <p>
                <?php
                if(!empty($flag_programado)){
                    echo Html::a('Actualizar Programado', ['updateprog', 'id' => $model->id], ['class' => 'btn btn-primary']);
                }
                else{
                    ?><?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?><?php
                }                
                ?><?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
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
<!--    <p style="text-align: right"> <?php // Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>Nuevo Destino',
//            ['destino/create', 'id'=>$model->id],
//            ['class'=>'btn btn-success btn-lg modalButton', 
//             'title'=>'Haga click aquí para agregar un Nuevo Destino', ]
//            );?>
    </p>-->
    <!--<h2>Destinos:</h2>-->
    <?php // Verifico si existe Dataprovider para que aparezca el Grid
    if ($dataProvider->totalCount > 0) {
 
                    ?>
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                     'dataProvider' => $dataProvider,
                     'toolbar' => [
                            ['content' =>
                                   Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>Nuevo Destino',
                                    ['destino/create', 'id'=>$model->id],
                                    ['class'=>'btn btn-success btn-lg modalButton', 
                                     'title'=>'Haga click aquí para agregar un Nuevo Destino', ]
                                    ),
                            ],
                    ],
        'panel' => [
                         'type' => GridView::TYPE_WARNING, 
                         'heading'=>'<h2>Destinos añadidos</h2>',
                         'footer'=>false],
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
                            [
                                'attribute' => 'observacion',
                                'label' => 'Observación',
                                'hAlign'=>'center',
                                'vAlign'=>'middle',
                                'format'=>'html'
                            ],             
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
                            ['class' => 'kartik\grid\ActionColumn',
                              'template'=>'{view}{update}{delete}',
                                'buttons'=>[
                                        'view' => function ($url, $model) { 
                                            $url = Yii::$app->urlManager->createAbsoluteUrl(['destino/'.$model->id]);
                                            return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
                                                      'class'=>'btn btn-warning btn-md modalButton','title' => Yii::t('yii', 'View'),
                                              ]); 
                                        },
                                        'update' => function ($url, $model) {     
                                            $url = Yii::$app->urlManager->createAbsoluteUrl(['destino/update/'.$model->id,  'id_envio' => $model->envio_id]);    
                                            return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                                                      'class'=>'btn btn-warning btn-md','title' => Yii::t('yii', 'Update'),
                                          ]); 
                                        },
                                        'delete' => function($url, $model) {
                                            $url = Yii::$app->urlManager->createAbsoluteUrl(['destino/'.$model->id]);    
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], ['class'=>'btn btn-warning btn-md',
                                            'title' => Yii::t('app', 'Deletee'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);        
                                        }        
                                ]                                      
                            ],           
                        ],
                                        
                    ]); ?>
                <?php Pjax::end(); 

 }
 else{
     ?><p style="text-align: right"> 
             <?= Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>Nuevo Destino',
            ['destino/create', 'id'=>$model->id],
            ['class'=>'btn btn-success btn-lg modalButton', 
             'title'=>'Haga click aquí para agregar un Nuevo Destino', ]
            );?>
    </p><?php
 }
?></div>
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
                        
    /*******************************************************************************************/                    
//                        Extraigo los nombres del origen y envio para capturar el primer y ultimo lugar
                        foreach($destinos_completos as $d){
                            $lugares[] = $d['direccion_destino'];                            
                        }
                        $primer_lugar = array_shift($lugares); //Extraigo primer elemento de array
                        $ultimo_lugar = array_pop($lugares);    //Extraigo ultimo elemento de array
                        $detalle_distancia_envio = $primer_lugar.' - '.$ultimo_lugar;
//                        print_r($detalle_distancia_envio);
    /*******************************************************************************************/                    
                        
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
                                }
//                                else{
//                                        print_r($lugar[$i][0]); echo(' ==> '); print_r($lugar[$i+1][0]);; echo("Distancia: ".$distance);echo('<br>');
//                                }
                                $dist_resto_puntos = $dist_resto_puntos +$distance;                
                            }
                            if(is_nan($dist_resto_puntos)){
                                $dist_resto_puntos ==0;
                            }
                            else{
    //                            echo('<h2>'); echo('Distancia resto de puntos:');echo($dist_resto_puntos);echo('</h2>');
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

    //                                    echo('<br>'); echo("<h3>Retornos : ". $valor_distancia_ret.'</h3>' );   
                                       } 
    //                                   echo('<br>'); echo("<h2>Valor de retornos es: ". $valor_distancia_retornos.'</h2>' );   
                            }
                            else{
                                        $valor_distancia_retornos = 0;
    //                                    print_r("no hay retornos");
                            }

                        //Calculo de retornos al inicio
                            $resultados = \app\models\Destino::find()->where(['retorno_inicio'=> 1])->andWhere(['envio_id'=>$model->id])->asArray()->all();
                            $valor_distancia_retorno_inicio = 0;
//                            print_r($resultados);
                            if(!empty($resultados)){
//                                print_r("si hay resultados");
                                        foreach($resultados as $r){
                                            //  $latitud_origen  coordenada de inicio
                                            //  $longitud_origen coordenada de inicio

                                        $coord_dest = \app\models\Destino::find()->select(['latitud', 'longitud'])->where(['id'=> $id_retorno_destino])->one();
                                            $lat_dest= $coord_dest['latitud'];    
                                            $long_dest= $coord_dest['longitud'];    
                                            $lugar_dest=$coord_dest['direccion_destino']; 

                                        $valor_distancia_ret_ini = $model->calculo_distancia($latitud_origen, $longitud_origen, $lat_dest, $long_dest);
                                        $valor_distancia_retorno_inicio = $valor_distancia_retorno_inicio + $valor_distancia_ret_ini;

//                                        echo('<br>'); echo("<h3>Retorno al inicio : ". $valor_distancia_ret_ini.'</h3>' );   
                                       } 
//                                       echo('<br>'); echo("<h2>Valor de retornos del inicio: ". $valor_distancia_retorno_inicio.'</h2>' );   
//                                       die();
                            }
                            else{
//                                print_r("no hay resultados");
                                        $valor_distancia_retorno_inicio = 0;
    //                                    print_r("no hay retorno al inicio");
                            }

                         //Distancia sumada de los 2 primeros puntos + el resto 
                            if(is_nan($dist_resto_puntos)){
                                $total_km = $dist_origen_primer_punto + $valor_distancia_retornos+ $valor_distancia_retorno_inicio;
                            }
                            else{
                                $total_km = $dist_resto_puntos + $dist_origen_primer_punto + $valor_distancia_retornos+ $valor_distancia_retorno_inicio;
                            }
    //                        echo('<h2>'); echo('Distancia Total: ');echo($total);echo('</h2>');

                            $valor_km = $model->calculo_valores($total_km);
    }    
     //*****************Fin Calculo de Distancias******************
         
//    Detalle de Distancias y costos
//print_r($dist_origen_primer_punto); echo('<br>');
//print_r($dist_resto_puntos); echo('<br>');
if(!empty($dist_origen_primer_punto) || !empty($dist_resto_puntos)){
//if(($dist_origen_primer_punto>0) || !empty($dist_resto_puntos)){
//if(!empty($dist_resto_puntos)){
    ?>
    <center><h2 class="bg-warning text-white">Detalle de distancias y Costo referencial</h2></center>
    <table class="table table-hover table-condensed">
      <thead class="thead-inverse">
        <tr>
          <th class="warning"><h3>Item</h3></th>
          <th class="warning"><h3>Valor</h3></th>
        </tr>
      </thead>
      <tbody>
        <tr class="table-warning">
          <td>Distancia entre el Origen y el Primero Destino (km)</td>
          <td><?php echo('<strong>'); echo(round($dist_origen_primer_punto, 2)); echo('</strong>');?></td>
        </tr>
        <tr>
          <td>Distancia en resto de Destinos (km)</td>
          <td><?php 
                  if (is_nan($dist_resto_puntos)) {
                      $dist_resto_puntos = 0;
                      echo($dist_resto_puntos);
                  } else {
                      echo('<strong>');echo($dist_resto_puntos);echo('</strong>');
                  }
                  ?>
          </td>
        <tr>
            <?php
             for($i = 0; $i<count($destinos_completos); $i++){          
                                  $punto[] = [$destinos_completos[$i]['latitud'] , $destinos_completos[$i]['longitud']];
                                  $lugar[] = [$destinos_completos[$i]['direccion_destino']];
                                  $distance = \Yii::$app->googleApi->getDistance($punto[$i], $punto[$i+1], $unit);
                                  if(is_nan($distance)){
                                      $dist_resto_puntos ==0;
                                  }
                                  else{
                                      //$lug[] = $lugar[$i][0]. ' -- '. $lugar[$i+1][0].' :'. '<strong>'.$distance.'</strong>';                                      
                                      $lug[] = $lugar[$i][0]. ' -- '. $lugar[$i+1][0];                                      
                                      $dis[] = $distance;
                                  }                                                                   
                              }
                              if((!empty($lug) &&(!empty($dis)))){
                                    unset($lug[0]);
                                    unset($dis[0]);
//                                    foreach($lug as $l){
//                                            $lugares = $l;
//                                            echo('&ensp; &ensp;');print_r($lugares); echo('<br>');
//                                        }
//                                        foreach($dis as $d){
//                                            $distancias = $d;
//                                            echo('&ensp; &ensp;');print_r($distancias); echo('<br>');
//                                        }
                                     echo('<td>');   
                                     foreach($lug as $l){
                                            $lugares = $l;
                                            echo('<div>&ensp;&ensp;');print_r($lugares); echo('</div><br>');
                                        }
                                     echo('</td>');
                                     echo('<td>');
                                        foreach($dis as $d){
                                            $distancias = $d;
                                            echo('<div>');print_r($distancias); echo('</div><br>');
                                        }    
                                    echo('</td>');    
                              }    
            ?>
        </tr>  
        </tr>
        <tr>
          <td>Distancia de Retornos a Destinos determinados (km)</td>
          <td><?php echo('<strong>'); echo($valor_distancia_retornos);echo('</strong>');?></td>
        </tr>
        <tr>
          <td>Distancia de Retornos al Origen (km)</td>
          <td><?php echo('<strong>');echo($valor_distancia_retorno_inicio); echo('</strong>');?></td>
        </tr>
        <tr>
          <td>Total de Kilómetros (km)</td>
          <td><?php echo('<strong>');echo($total_km); echo('</strong>');?></td>
        </tr>
        <tr>
            <td class="warning"><h3><strong>Costo Referencial (USD)</strong></h3></td>
           <td class="warning"><h3><strong><?php echo($valor_km);?></strong></h3></strong></td>
        </tr>
      </tbody>
    </table>

            <!---------------------------------------------CONTINUAR---------------------------------------------------------------->
    <?php
    //Datos para la factura
    $profile = Yii::$app->user->identity->profile;
        $nombre = $profile->full_name;
        $direccion = $profile->direccion;
        $telefono = $profile->telefono;
        $cedula = $profile->cedula;
        $email = Yii::$app->user->identity['email'];
    
    //Valor de Recarga
    $id_usuario = Yii::$app->user->identity['id'];
    $query= app\models\Recarga::find()->where(['user_id'=>$id_usuario])->asArray()->one();
        $valor_recarga = $query['valor_recarga'];
    
    
//    print_r($nombre);echo('<br>');
//    print_r($direccion);echo('<br>');
//    print_r($telefono);echo('<br>');
//    print_r($cedula);echo('<br>');
//    print_r($email);echo('<br>');
//    print_r($valor_recarga);echo('<br>');
    
    
    if($valor_recarga > $valor_km){
    ?>
    <div class="row">        
    <div class="col-lg-5  col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading"> <center><h2><strong>Condiciones de Aceptación</strong></h2></center></div>
                <div class="panel-body">   
                    <p>Al aceptar, se generará la factura correspondiente con sus datos y se descontará de su saldo de Recarga</p>
                    <div class="row">
                            <center>   
                                <div class="col-lg-6">
                            <p> <?= Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>Aceptar y Continuar',
                                        ['envio/detalles', 
                                            //Datos para Factura:
                                            'detalle_distancia_envio'=>$detalle_distancia_envio,
                                            'total_km'=>$total_km,
                                            'valor_km'=>$valor_km, 
                                            'nombre'=>$nombre, 
                                            'direccion'=>$direccion, 
                                            'telefono'=>$telefono, 
                                            'cedula'=>$cedula, 
                                            'email'=>$email, 
                                            'valor_recarga'=>$valor_recarga, 

                                            //Datos para dibujar el Google Maps:                                    
                                            'dist_origen_primer_punto'=>$dist_origen_primer_punto,
                                            'dist_resto_puntos'=>$dist_resto_puntos,
                                            'valor_distancia_retornos'=>$valor_distancia_retornos,
                                            'valor_distancia_retorno_inicio'=>$valor_distancia_retorno_inicio,                    
                                            'latitud_origen'=>$latitud_origen,
                                            'longitud_origen'=>$longitud_origen,
                                        ],
                                        ['class'=>'btn btn-warning btn-lg', 'title'=>'Haga click para continuar', ]
                                        );
                                ?>
                            </p>
                            </div>    
                                
                                <div class="col-lg-6">
                            <p> <?= Html::a( '<i class="glyphicon glyphicon-remove" style="color:white"></i>Cancelar Envío',
                                        ['#'],
                                        ['class'=>'btn btn-danger btn-lg', 'title'=>'Haga click para cancelar', 'data-confirm' => '¿Estás seguro que deseas cancelar el envío?',]
                                        );
                                ?>
                            </p>
                            </div>    
                            </center>                    
                    </div>    
                </div>
            </div>  
    </div>                    
    </div> 
    <?php
    }
    else{
    ?>
    <div class="col-lg-12  col-sm-12">
        <div class="alert alert-danger"><h2><strong>ATENCION</strong></h2><p>Su saldo de recarga es insuficiente para poder continuar. Por favor recarge saldo</p></div>
    </div>
    <center><p> 
            <?=
               Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>'. ' Recarga Saldo',
                       ['//recarga-transferencia/create', 'user_id'=>$id_usuario],                   
                       ['class'=>'btn btn-warning btn-lg modalButton', 'title'=>'Haga click aquí para recargar Saldo', ]
               );
            ?>    
    </p></center>

    <?php
    }
    ?>
    
    
    
<?php
}
else {
    echo('<center><h3 class="alert alert-danger">Agregue mas Destinos para poder visualizar detalle de distancia aproximada y costos</h3></center>');
}
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
    /*display:none;*/
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