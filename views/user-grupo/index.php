<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserGrupoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignación de Usuarios a Grupos';
$this->params['breadcrumbs'][] = $this->title;

$responsable_id = Yii::$app->user->identity['id'];
?>
<div class="user-grupo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Asignación', ['create'], ['class' => 'btn btn-success modalButton']) ?>
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
//            'user_id',
            [
                 'label' =>"usuario",               
                 'attribute' => 'user_id',
                 'hAlign'=>'center',
                 'vAlign'=>'middle',
                 'value'=>function($model) {
                   $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->user_id])->asArray()->one();
                     return $service ? $service['full_name'] : '-';
                 },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\User::find()->where(['responsable_id'=>$responsable_id])->asArray()->all(), 'id', 'username'), 

                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Usuario'],              
            ], 
            
//            'grupo_usuarios_id',
          [
                 'label' =>"Grupo Asignado",               
                 'attribute' => 'grupo_usuarios_id',
                 'hAlign'=>'center',
                 'vAlign'=>'middle',
                 'value'=>function($model) {
//                   $responsable_id = Yii::$app->user->identity['id'];
//                   $service = app\models\GrupoUsuarios::find()->where(['responsable_user_id'=>$responsable_id])->asArray()->one();
//                   $service = app\models\GrupoUsuarios::find()->asArray()->one();
                   $service = app\models\GrupoUsuarios::findOne($model->grupo_usuarios_id);
                     return $service ? $service['grupo'] : '-';
                 },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\GrupoUsuarios::find()->where(['responsable_user_id'=>$responsable_id])->asArray()->all(), 'id', 'grupo'), 

                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Usuario'],              

          ],                
//            'created_at',
          [
                 'label' =>"Creado el",               
                 'attribute' => 'created_at',
                 'hAlign'=>'center',
                 'vAlign'=>'middle',
                  'filter'=>false,       
            ],               
//            'updated_at',
            // 'banned_at',

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