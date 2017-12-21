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
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<h3>Búsqueda de Mensajeros</h3>';
$this->title = 'Búsqueda de Mensajeros';
?>
<p>Para mostrar la ubicación de un mensajero, por favor seleccione un mensajero y haga click en Buscar</p>
 
 <fieldset class="col-lg-8 col-lg-offset-2">    	
    <!--<legend class=" fondo_tomate"><h4>Búsqueda</h4></legend>-->					
        <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tracking-search">
                        <?php
                        $model = new \app\models\Tracking;
                        $form = ActiveForm::begin(['action' => ['busquedamensajero'],'method' => 'get']);
                        ?>

                        <?php
                        //Mensajeros que se encuentran en la tabla Tracking
                        $mensajeros = (new \yii\db\Query())
                                ->select(["p.user_id", "p.full_name"])
                                ->from('profile p, user u')
                                ->where('exists (select * from tracking as l where l.user_id = p.user_id)')
                                ->andWhere('u.id = p.user_id')
                                ->andWhere('u.role_id = 3')
                                ->groupBy('p.user_id')
                                ->orderBy('p.full_name')
                                ->all();

                        $data = ArrayHelper::map($mensajeros, 'user_id', 'full_name');
                        ?>

                        <?= $form->field($model, 'user_id')->label('Seleccione un Mensajero:')->dropDownList($data, ['prompt' => '--Seleccione un Mensajero--']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Buscar', ['class' => 'btn btn-warning btn-lg']) ?>
                            <?php // Html::resetButton('Limpiar', ['class' => 'btn btn-default btn-lg']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                    </div>
                </div>
        </div>
 </fieldset>


<center>
        <?php
        Pjax::begin(['id' => 'myPjax']);
        if(!empty($latitud) && !empty($longitud) && !empty($full_name)){               
            echo "<div class='row'>"
            . "<div class='col-lg-8 col-lg-offset-2'>"
            . "<div class='col-lg-4'><img src=".$foto." width='75' height='75'/></div>"
            . "<div class='alert alert-warning' style='text-align:left; height:80px;'><span><strong>RESULTADO</strong></span><br><strong>Nombre:</strong> ".$full_name." <br><strong>Ultimo registro:</strong> ". $fecha. "</div>"
            . "</div>"
            . "</div>";      

            $coord = new LatLng(['lat' => $latitud, 'lng' => $longitud]);
            $map = new Map([
                'center' => $coord,
                'zoom' => 17,
                'width' => '90%',
                'containerOptions' => [
                    'id' => 'mapa'
                ],                
            ]);
            
            //Estraigo status y seteo el icono de la tabla StatusMensajero
            $query = \amnah\yii2\user\models\User::find()->where(['id'=>$user_id])->asArray()->one();
            $status = $query['status_id'];
                    $query_estado = app\models\StatusMensajero::findOne($status);
//                    $estado ? $estado['status'] : '-';
                    if(!empty($query_estado)){
                        $estado = $query_estado['status'];
                    }
                    else{
                        $estado = "no determinado";
                    }
                    
            $quey_status = app\models\StatusMensajero::find()->where(['id'=>$status])->asArray()->one();
            $icono_status = $quey_status['icono'];

            $coord = new LatLng(['lat' => $latitud, 'lng' => $longitud]);
            $marker = new Marker([
                        'position' => $coord,
                        'title' => $full_name,
                        'animation' => 'google.maps.Animation.DROP',
                        'visible'=>'true',
                        'icon'=>\yii\helpers\Url::base().'/images/markers/estados_mensajeros/'.$icono_status,
//                        'options' => [
//                            'id' => 'mapa',
//                            'size'=>'google.maps.Size(50, 55)'
//                        ],
                        
                    ]);
            $marker->attachInfoWindow(new InfoWindow(['content' => $full_name.'<br> ('.$estado.')']));
//            $marker->attachInfoWindow(new InfoWindow(['content' => '<img border="0" align="center" src="/images/objekat.jpg" width="222">']));
            $map->addOverlay($marker);
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
</center>
  
 
<style>
     fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		min-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
	}	
	
		legend
		{
			font-size:14px;
			font-weight:bold;
			margin-bottom: 0px; 
			width: 35%; 
			border: 1px solid #ddd;
			border-radius: 4px; 
			padding: 5px 5px 5px 10px; 
			background-color: #ffffff;
		}
</style>                