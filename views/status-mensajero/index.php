<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StatusMensajeroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Status Mensajeros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-mensajero-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Status', ['create'], ['class' => 'btn btn-warning']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
            'color',
//            'icono',
            [
             'attribute' => 'icono',
             'format' => 'raw',
             'label'=>'Iconos',
             'hAlign'=>'center',
             'vAlign'=>'middle',  
             'width'=>'85px',   
             'value' => function ($model) {         
                if ($model->icono!=''){
                  return Html::a(Html::img(Yii::$app->homeUrl.'/images/markers/estados_mensajeros/'.$model->icono, ['alt'=>'Icono', 'id' => 'myImg','height'=>'40px', 'width'=>'40px',]), '');
                }
                else{
                    return "<p class='bg-danger text-danger'>Sin ícono</p>";
                }
             },
             'format' => ['raw'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
