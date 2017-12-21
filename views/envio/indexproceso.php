<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\rating\StarRating;
use kartik\grid\EditableColumnAction;
use kartik\editable\Editable;

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
            'heading' => 'EN PROCESO',
//            'footer' =>false,
        ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
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
//             'fecha_fin_envio',
             'total_km',
             'valor_total',
//             'tiempo_estimado',
            [
                'label' => 'Tiempo Estimado (m)',
                'attribute' => 'tiempo_estimado',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'filter'=>false        
            ],
            [
                'label'=>'Envio de tipo',
                'attribute' => 'modo_envio',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value'=>function($model, $key, $index, $column) {
                             if($model->modo_envio ==1){
                                 return "Envío Normal";
                             }
                             else if($model->modo_envio ==2){
                                 return "Envío Programado";
                             }
                             else if($model->modo_envio ==3){
                                 return "Envío Recurrente";
                             }
                             else{
                                 return " ";
                             }
                             
                },
                'filter'=>false
            ],                      

             [
                'label' => "Mensajero",
                'attribute' => 'mensajero_id',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value'=>function($model, $key, $index, $column) {
                            $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->mensajero_id])->asArray()->one();
                            $full_name = $service['full_name'];
                            return $full_name ? $full_name : '-';
                         },                                
                'filter'=>false        
            ],    
                                 
/***************************************** FUNCIONALIDAD DE BOTON MODAL*****************************************/            
            ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Tiempo<br> Real',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'buttons' => 
                    [                           
                        'custom_view' => function ($url, $model) {
                             if(!empty($model->mensajero_id)){
                                return Html::a( '<i class="glyphicon glyphicon-eye-open" style="color:white"></i>',
                                                        ['/envio/tiemporeal', 
                                                            'envio_id'=>$model['id'],
                                                            'mensajero_id'=>$model['mensajero_id'],
                                                            ],
                                                        ['class'=>'btn btn-warning btn-md', 'title'=>'Envio en Tiempo real', ]
                                                );
                             }
                        },
                    ]
            ],
/***************************************** FUNCIONALIDAD DE BOTON MODAL*****************************************/                                    
                                 
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

<span id="rating-static rating-30"></span>
        
<style>
    thead{
        color: #3c8dbc;
      }
      
    
    
    /*Estrellas*/
    .rating-static {
        width: 60px;
        height: 16px;
        display: block;
        background: url('http://www.itsalif.info/blogfiles/rating/star-rating.png') 0 0 no-repeat;
        
        margin-top: 50%;
        margin-left: 25%;
        margin-right: 25%;        
    }
    
/*    td{
        text-align: center;
        position: relative;
        top: 50%;
        -ms-transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }*/
    .rating-5 { background-position: 0 0; }
    .rating-4 { background-position: -12px 0; } 
    .rating-3 { background-position: -24px 0; }
    .rating-2 { background-position: -36px 0; }
    .rating-1 { background-position: -48px 0; }
    .rating-0 { background-position: -60px 0; }
    
    
    
    
    .div {
  position: relative;
  width: 0;
  height: 0;
  border-left: 75px solid transparent;
  border-right: 75px solid transparent;
  border-bottom: 150px solid green;
}

.div:after {
  position: absolute;
  width: 0;
  height: 0;
  top: 50px;
  left: -75px;
  content: "";
  border-left: 75px solid transparent;
  border-right: 75px solid transparent;
  border-top: 150px solid green;
}

#circle {
    width: 50px;
    height: 50px;
    background: #7fee1d;
    -moz-border-radius: 60px;
    -webkit-border-radius: 60px;
    border-radius: 60px;
}

#star6 {
 width: 0;
 height: 0;
 border-left: 50px solid transparent;
 border-right: 50px solid transparent;
 border-bottom: 100px solid #05ed08;
 position: relative;
}
#star6:after {
 width: 0;
 height: 0;
 border-left: 50px solid transparent;
 border-right: 50px solid transparent;
 border-top: 100px solid #05ed08;
 position: absolute;
 content: "";
 top: 30px;
 left: -50px;
}

</style>    