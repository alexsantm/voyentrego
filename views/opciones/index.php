<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OpcionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Opciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="opciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Opciones', ['create'], ['class' => 'btn btn-success modalButton']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'panel' => [
          'type' => GridView::TYPE_WARNING,
          'heading' =>'Panel de Opciones',
          'footer'=>false  
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'radio',
//            [
//                'attribute' => 'radio',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'radio',
                'label' => 'Radio',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'editableOptions' => [
                    'name'=>'radio', 
                    'placement'=> 'right', 
                    'asPopover' => true,
                    'header' => 'Radio',
                    'size'=>'md',
                    'options' => ['class'=>'form-control', 'placeholder'=>'Ingrese la Referencia Bancaria...']
                ],        
            ],
//            'dia_pago_mensajeros',
//            'envios_tomados_por_dia',
//            [
//                'attribute' => 'envios_tomados_por_dia',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ],
             [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'envios_tomados_por_dia',
                'label' => 'Envíos tomados por dia',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'editableOptions' => [
                    'name'=>'envios_tomados_por_dia', 
                    'placement'=> 'right', 
                    'asPopover' => true,
                    'header' => 'Envíos tomados por día',
                    'size'=>'md',
                    'options' => ['class'=>'form-control', 'placeholder'=>'Ingrese los días tomados por día...']
                ],        
            ],
//            'foto_promocion',
            [
                'attribute' => 'foto_promocion',
                'format' => 'raw',
                'label'=>'Foto de Promoción',
                'hAlign'=>'center',
                'vAlign'=>'middle',    
                'value' => function ($model) {   
                   if ($model->foto_promocion!='')
                     return Html::a(Html::img(Yii::$app->homeUrl. '/images/promociones/'.$model->foto_promocion), Yii::$app->homeUrl. '/images/promociones/'.$model->foto_promocion, ['rel' => 'fancybox']);
                },
            ],
                        
//            [
//                'attribute' => 'tiempo_refresco',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ],
             
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'tiempo_refresco',
                'label' => 'tiempo de Refresco',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'editableOptions' => [
                    'name'=>'tiempo_refresco', 
                    'placement'=> 'right', 
                    'asPopover' => true,
                    'header' => 'Tiempo de Refresco',
                    'size'=>'md',
                    'options' => ['class'=>'form-control', 'placeholder'=>'Ingrese tiempo (milisegundos)...']
                ],        
            ],            
                        
            
//            [
//                'attribute' => 'frec_almacenamiento_stand_by',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ],
                        
             [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'frec_almacenamiento_stand_by',
                'label' => 'Frecuencia de almacenamiento Stand By',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'editableOptions' => [
                    'name'=>'frec_almacenamiento_stand_by', 
                    'placement'=> 'right', 
                    'asPopover' => true,
                    'header' => 'Frecuencia de almacenamiento Stand By',
                    'size'=>'md',
                    'options' => ['class'=>'form-control', 'placeholder'=>'Ingrese tiempo (milisegundos)...']
                ],        
            ],             

//            [
//                'attribute' => 'frec_envio_stand_by',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ],
                        
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'frec_envio_stand_by',
                'label' => 'Frecuencia de envio Stand By',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'editableOptions' => [
                    'name'=>'frec_envio_stand_by', 
                    'placement'=> 'right', 
                    'asPopover' => true,
                    'header' => 'Frecuencia de envio Stand By',
                    'size'=>'md',
                    'options' => ['class'=>'form-control', 'placeholder'=>'Ingrese tiempo (milisegundos)...']
                ],        
            ],
                        
//            [
//                'attribute' => 'frec_almacenamiento_reparto',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ],
                        
             [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'frec_almacenamiento_reparto',
                'label' => 'Frecuencia de Almacenamiento de Reparto',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'editableOptions' => [
                    'name'=>'frec_almacenamiento_reparto', 
                    'placement'=> 'right', 
                    'asPopover' => true,
                    'header' => 'Frecuencia de Almacenamiento de Reparto',
                    'size'=>'md',
                    'options' => ['class'=>'form-control', 'placeholder'=>'Ingrese tiempo (milisegundos)...']
                ],        
            ],
                        
//            [
//                'attribute' => 'frec_envio_reparto',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ],

            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'frec_envio_reparto',
                'label' => 'Frecuencia de Envio de Reparto',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'editableOptions' => [
                    'name'=>'frec_envio_reparto', 
                    'placement'=> 'left', 
                    'asPopover' => true,
                    'header' => 'Frecuencia de Envio de Reparto',
                    'size'=>'md',
                    'options' => ['class'=>'form-control', 'placeholder'=>'Ingrese tiempo (milisegundos)...']
                ],        
            ],

//            ['class' => 'yii\grid\ActionColumn'],
            	 /***************************************** FUNCIONALIDAD DE BOTON MODAL*****************************************/            
            ['class' => 'kartik\grid\ActionColumn',
                'template'=>'{custom_view}',
                'header'=>'Actualizar',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'buttons' => 
                [   
                    'custom_view' => function ($url, $model) {
                            // Html::a args: title, href, tag properties.
                            return Html::a( '<i class="glyphicon glyphicon-pencil" style="color:white"></i>',
                                                    ['opciones/update', 'id'=>$model['id']],
                                                    ['class'=>'btn btn-warning btn-md modalButton', 'title'=>'Actualizar Opciones', ]
                                            );
                    },
                ]
            ],
        /***************************************** FUNCIONALIDAD DE BOTON MODAL*****************************************/             
        ],
    ]); ?>
</div>

<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-lg',
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
    .opciones-index img{
        width: 100px;
        height: 85px;
        /*border: solid 2px red;*/
    }
    
    .kv-panel-before, .kv-panel-after {
        display:none;
    }
</style>    