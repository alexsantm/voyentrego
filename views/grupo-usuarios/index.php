<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GrupoUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupo Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupo-usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Grupo de Usuarios', ['create'], ['class' => 'btn btn-success modalButton']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_WARNING,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'grupo',
            [
                 'label' =>"Grupo",               
                 'attribute' => 'grupo',
                 'hAlign'=>'center',
                 'vAlign'=>'middle',
                  'filter'=>false,       
            ],
//            'responsable_user_id',
            [
                 'label' =>"Responsable",               
                 'attribute' => 'responsable_user_id',
                 'hAlign'=>'center',
                 'vAlign'=>'middle',
                 'value'=>function($model) {
                   $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->responsable_user_id])->asArray()->one();
                     return $service ? $service['full_name'] : '-';
                 },  
                  'filter'=>false,       
            ], 
//            'fecha',
            [
                 'label' =>"Fecha",               
                 'attribute' => 'fecha',
                 'hAlign'=>'center',
                 'vAlign'=>'middle',
                  'filter'=>false,       
            ],

            ['class' => 'yii\grid\ActionColumn'],
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