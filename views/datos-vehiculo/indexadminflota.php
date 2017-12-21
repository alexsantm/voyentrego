<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DatosVehiculoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Datos Vehiculos de Administrador de Flota';
$this->params['breadcrumbs'][] = $this->title;

$responsable_id = Yii::$app->user->identity['id'];
?>
<div class="datos-vehiculo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Añadir Vehiculo a la Flota', ['createadminflota'], ['class' => 'btn btn-warning modalButton']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_WARNING,
            'heading'=>'Agregue un Vehículo a su Flota'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'user_id',
//            [
//                 'label' =>"usuario",               
//                 'attribute' => 'user_id',
//                 'hAlign'=>'center',
//                 'vAlign'=>'middle',
//                 'value'=>function($model) {
//                   $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->user_id])->asArray()->one();
//                     return $service ? $service['full_name'] : '-';
//                 },
//                'filterType'=>GridView::FILTER_SELECT2,
//                'filter'=>ArrayHelper::map(app\models\User::find()->where(['responsable_id'=>$responsable_id])->asArray()->all(), 'id', 'username'), 
//
//                'filterWidgetOptions'=>[
//                    'pluginOptions'=>['allowClear'=>true],
//                ],
//                'filterInputOptions'=>['placeholder'=>'Usuario'],              
//            ], 
            'marca',
            'modelo',
            'anio',
             'placa',
            // 'responsable_user_id',
             'fecha',
            // 'estado_id',

//            ['class' => 'yii\grid\ActionColumn'],
[
        'class' => '\kartik\grid\ActionColumn',
        'template' => '{update} {delete}',
//        'buttons'  => [
//        'view' => function($url, $model) {
//                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
//                        'title' => Yii::t('app', 'View'),]);
//        }
//        ],
        'buttons'  => [
        'update' => function($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['updateadminflota'], [
                        'title' => Yii::t('app', 'Updateadminflota'),]);
        }
        ],
        'buttons'  => [
        'delete' => function($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], [
                        'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);
        }
        ],

//        'urlCreator' => function ($action, $model, $key, $index) {
//        if ($action === 'view') {
//                $url = 'index.php?r=datos_vehiculo/view&id='.$model['id'].'&role_id='.$model['role_id'];
//                return $url;
//        }
//        if($action === 'update') {
//                $url = 'index.php?r=datos_vehiculo/updateadminflota&id='.$model['id'].'&role_id='.$model['role_id'];
//                return $url;
//        }
//        }
]
            
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