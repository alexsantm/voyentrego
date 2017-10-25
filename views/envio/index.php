<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EnvioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Detalle de Envíos';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="envio-index">

    <div class="row">
        <div class="col-lg-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>   
        <div class="col-lg-6"><br>
            <p style="text-align: right">
                <?= Html::a('Nuevo Envio', ['create'], ['class' => 'btn btn-warning btn-lg']) ?>        
            </p>
        </div>
    </div>
    
    
<?php Pjax::begin(); ?>    
<?php $realizados = GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_WARNING,
            //'heading' => 'ENVIOS REALIZADOS:</h3>',
            'heading' => 'REALIZADOS',
//            'footer' =>false,
        ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'label' => "Ciudad",
                'attribute' => 'ciudad_id',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                //'width'=>'450px',
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\Ciudad::findOne($model->ciudad_id);
                    return $service ? $service->ciudad : '-';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Ciudad::find()->asArray()->all(), 'id', 'ciudad'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Escoga Ciudad'],         
            ],
//            'user_id',
//            'remitente',
            [
                'attribute' => 'remitente',
                'hAlign'=>'center',
                'vAlign'=>'middle',
            ],             
//            'direccion_origen',
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
            // 'fecha_fin_envio',
            // 'total_km',
            // 'valor_total',
//             'observacion:html',
            [
                'attribute' => 'observacion',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'format'=>'html',
                'filter'=>false
            ],                      
            [
                'label' => "Estado",
                'attribute' => 'estado_envio_id',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                //'width'=>'450px',
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\EstadoEnvio::findOne($model->estado_envio_id);
                    return $service ? $service->estado : '-';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\EstadoEnvio::find()->asArray()->all(), 'id', 'estado'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Escoga Estado'],      
            ],
//             'tipo_envio_id',
//             'dimensiones_id',
            // 'mensajero_id',
         ['class' => 'kartik\grid\ActionColumn',
                          'template'=>'{view}{update}{delete}',
                            'buttons'=>[
                                    'view' => function ($url, $model) {     
                                    return Html::a('<i class="glyphicon glyphicon-eye-open"></i>',['envio/vistaenvio', 'id'=>$model->id], [
                                              'class'=>'btn btn-warning btn-md modalButton','title' => Yii::t('yii', 'View'),
                                      ]); 
                                    },
                                    'update' => function ($url, $model) {     
                                    return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                                              'class'=>'btn btn-warning btn-md','title' => Yii::t('yii', 'Update'),
                                      ]); 
                                    },
                                    'delete' => function($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], ['class'=>'btn btn-warning btn-md',
                                    'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);        
                                    }        
                            ]                                      
            ],                               
        ],
    ]); ?>
<?php Pjax::end(); ?>

<?php 
        $user_id = Yii::$app->user->identity['id'];
        $searchModel = new \app\models\EnvioSearch();
        $searchModel->user_id = $user_id;
        $searchModel->estado_envio_id = 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $exitosos = $this->render('/envio/indexexitoso', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
?>


</div>

<?php
/******************************************************************************************************************************************/
?>

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

<?php
echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'encodeLabels'=>false,
    'enableStickyTabs'=>true,
//    'position'=>TabsX::POS_RIGHT,
    'items' => [
        [
            'label' => '<i class="glyphicon glyphicon-list-alt"></i> ENVIOS REALIZADOS',
            'content' => $realizados,
            'active' => true,
            'bordered'=>true,
            'height'=>TabsX::SIZE_LARGE,
            'headerOptions' => ['style'=>'font-weight:bold; font-size:18px;'],
        ],
        [
            'label' => '<i class="glyphicon glyphicon-ok"></i> ENVIOS EXITOSOS',
            'content' => $exitosos,
            'headerOptions' => ['style'=>'font-weight:bold; font-size:18px;'],
            'options' => ['id' => 'opciones'],
            'height'=>TabsX::SIZE_LARGE,
            'bordered'=>true,
        ],
//        [
//            'label' => 'Tipos de Envìo',
//            'content' => $tipo_envio,
//            'headerOptions' => ['style'=>'font-weight:bold'],
//            'options' => ['id' => 'tipo_envio'],
//            'bordered'=>true,
//        ],
//        
//        [
//            'label' => 'Dimensiones',
//            'content' => $dimensiones,
//            'headerOptions' => ['style'=>'font-weight:bold'],
//            'options' => ['id' => 'dimensiones'],
//            'bordered'=>true,
//        ],
    ],
]);
?>


