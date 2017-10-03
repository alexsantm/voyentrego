<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\rating\StarRating;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EnvioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Envios exitosos';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="envio-index">

    <!--<h1>-->
        <?php // Html::encode($this->title) ?>
    <!--</h1>-->
    <!--<p>-->
        <?php // Html::a('Nuevo Envio', ['create'], ['class' => 'btn btn-warning']) ?>
    <!--</p>-->
<?php Pjax::begin(); ?>   
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_WARNING,
            'heading' => 'EXITOSOS',
            'footer' =>false,
        ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            [
//                'label' => "Ciudad",
//                'attribute' => 'ciudad_id',
//                'hAlign' => 'center',
//                'vAlign' => 'middle',
//                //'width'=>'450px',
//                'value' => function($model, $key, $index, $column) {
//                    $service = app\models\Ciudad::findOne($model->ciudad_id);
//                    return $service ? $service->ciudad : '-';
//                },
//                'filterType'=>GridView::FILTER_SELECT2,
//                'filter'=>ArrayHelper::map(app\models\Ciudad::find()->asArray()->all(), 'id', 'ciudad'), 
//                'filterWidgetOptions'=>[
//                    'pluginOptions'=>['allowClear'=>true],
//                ],
//                'filterInputOptions'=>['placeholder'=>'Escoga Ciudad'],         
//            ],
//            'user_id',
//             [
//                'attribute' => 'remitente',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ], 
             [
                'attribute' => 'direccion_origen',
                'hAlign'=>'center',
                'vAlign'=>'middle',
            ], 
//             'latitud',
//             'longitud',
            // 'celular',
//             'fecha_registro',
            [
                'attribute' => 'fecha_registro',
                'filterType' => GridView::FILTER_DATE,
                //'width'=>'515px',
                'hAlign'=>'center',
                'vAlign'=>'middle',
//                'width'=>'50%',                
//                'format'=>'date',
                'value'=>function($model, $key, $index, $column) {
                             return $model->fecha_registro;
                         },
                'headerOptions'=>['class'=>'kv-sticky-column'],
                'contentOptions'=>['class'=>'kv-sticky-column'],            
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Escoga una Fecha'], //this code not giving any changes in browser
                    'type' => kartik\widgets\DatePicker::TYPE_COMPONENT_APPEND, //this give error Class 'DatePicker' not found
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ],
            ],            
             'fecha_fin_envio',
             'total_km',
             'valor_total',
//             'observacion:html',
//            [
//                'attribute' => 'observacion',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//                'format'=>'html',
//                'filter'=>false
//            ],                      
            [
                'label' => "Estado",
                'attribute' => 'estado_envio_id',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\EstadoEnvio::findOne($model->estado_envio_id);
                    return $service ? $service->estado : '-';
                },
                'filter'=>false        
            ],
//             'tipo_envio_id',
//             'dimensiones_id',
//             'mensajero_id',
             [
                'label' => "Mensajero",
                'attribute' => 'mensajero_id',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\Profile::findOne($model->mensajero_id);
                    return $service ? $service->full_name : '-';
                },
                'filter'=>false        
            ],   
            [
                'label' => "Calificación",
                'attribute' => '',
                'hAlign' => 'center',
                'vAlign' => 'middle',
//                'value' => function($model, $key, $index, $column) {
//                    $service = \app\models\Calificacion::find()->where(['mensajero_id'=>$model->mensajero_id])->asArray()->one();
//                    return $service ? $service['calificacion'] : '-';
//                },
                'value' => function($model, $key, $index, $column) {
                    $service = \app\models\Calificacion::find()->where(['mensajero_id'=>$model->mensajero_id])->asArray()->one();
                    return $service ? $service['calificacion'] : '-';                    
                },        
                'contentOptions' => function ($model, $key, $index, $column) {
                    $service = \app\models\Calificacion::find()->where(['mensajero_id'=>$model->mensajero_id])->asArray()->one();
                    //return $service ? $service['calificacion'] : '-';  
                    $calificacion = $service['calificacion'];
                   if(($calificacion == 1) || ($calificacion == 2)){
                        return ['class' => 'alert alert-danger', 'style'=>'border-radius: 10px;'];                           
                   }
                   else if(($calificacion == 4) || ($calificacion == 5)){
                        return ['class' => 'alert alert-success', 'style'=>'border-radius: 10px;'];                           
                   }
                   else if(($calificacion == 3)){
                        return ['class' => 'alert alert-info', 'style'=>'border-radius: 10px;'];                           
                   }
            },        
                'filter'=>false        
            ],            
             ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Calificar Mensajero',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'buttons' => 
                    [                           
                        'custom_view' => function ($url, $model) {
                                $query = app\models\Calificacion::find()
                                        ->where(['user_id'=>$model['user_id']])
                                        ->andWhere(['mensajero_id'=>$model['mensajero_id']])
                                        ->andWhere(['envio_id'=>$model['id']])
                                        ->asArray()->one();
                                if(empty($query)){  
                                        return Html::a( '<i class="glyphicon glyphicon-thumbs-up" style="color:white"></i>',
                                                        ['/calificacion/create', 
                                                            'user_id'=>$model['user_id'],
                                                            'mensajero_id'=>$model['mensajero_id'],    
                                                            'envio_id'=>$model['id'],
                                                        ],
                                                        ['class'=>'btn btn-warning btn-lg modalButton', 'title'=>'Califique al Mensajero', ]
                                        );
                                }
                                else{
//                                    return "<div class='alert alert-success'>Calificado</div>";
                                    return "Calificado";
                                }
                        },
                    ]
            ],              
        ],
    ]); ?>
<?php Pjax::end(); ?></div>


<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-md',
		'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
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


<style>
    thead{
        color: #3c8dbc;
      }
</style>    