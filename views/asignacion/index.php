<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AsignacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <h4><strong>Instrucciones:</strong></h4>
    <li>Ingrese una nueva Ruta, por ejemplo: /envio/create</li>
    <li>Realice una asignación, seleccionando el Rol y la ruta</li><br><br>
    
    
    <p>
        <?= Html::a('Nueva Ruta', ['//ruta/create'], ['class' => 'btn btn-warning modalButton']) ?>
        <?= Html::a('Nueva Asignación', ['create'], ['class' => 'btn btn-success modalButton']) ?>        
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
          'type' => GridView::TYPE_WARNING
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'role_id',
            [
                'label' => "Rol",
                'attribute' => 'role_id',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                //'width'=>'450px',
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\Role::findOne($model->role_id);
                    return $service ? $service->name : '-';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Role::find()->asArray()->all(), 'id', 'name'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Escoga un Rol'],         
            ],
//            'ruta_id',
            [
                'label' => "Ruta",
                'attribute' => 'ruta_id',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                //'width'=>'450px',
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\Ruta::findOne($model->ruta_id);
                    return $service ? $service->ruta : '-';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\Ruta::find()->asArray()->all(), 'id', 'ruta'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Escoga una Ruta'],         
            ],            
            'fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>


		<!--/************************************************** BOTON MODAL*************************************************/-->

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