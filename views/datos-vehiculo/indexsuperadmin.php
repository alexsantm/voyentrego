<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DatosVehiculoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignación de Usuarios a Flota';
$this->params['breadcrumbs'][] = $this->title;

$responsable_id = Yii::$app->user->identity['id'];
?>
<div class="datos-vehiculo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Añadir Vehiculo a la Flota', ['createadminflota'], ['class' => 'btn btn-success modalButton']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_WARNING,
            'heading'=>'Vehiculos por asignar',
            'footer'=>false,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'marca',
            'modelo',
            'anio',
             'placa',
            // 'responsable_user_id',
            [
                 'label' =>"Dueño",               
                 'attribute' => 'responsable_user_id',
                 'hAlign'=>'center',
                 'vAlign'=>'middle',
                 'value'=>function($model) {
                   $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->responsable_user_id])->asArray()->one();
                     return $service ? $service['full_name'] : '-';
                 },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\User::find()->where(['responsable_id'=>$responsable_id])->asArray()->all(), 'id', 'username'), 

                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Usuario'],              
            ],
             'fecha',
            // 'estado_id',

//            ['class' => 'yii\grid\ActionColumn'],
            	 /***************************************** FUNCIONALIDAD DE BOTON MODAL*****************************************/            
                ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Asignar',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'buttons' => 
                    [                           
                        'custom_view' => function ($url, $model) {
                                return Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>',
                                                        ['datos-vehiculo/updatesuperadmin', 'id'=>$model['id']],
                                                        ['class'=>'btn btn-warning btn-md modalButton', 'title'=>'Asignar Vehículos', ]
                                                );
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