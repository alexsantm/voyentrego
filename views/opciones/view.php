<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Opciones */

//$this->title = $model->id;
$this->title = 'Opciones';
$this->params['breadcrumbs'][] = ['label' => 'Opciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<center>
<div class="opciones-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php 
//        Html::a('Delete', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
    </p>

    <?php 
//        DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'radio',
//            'dia_pago_mensajeros',
//            'envios_tomados_por_dia',
//            'foto_promocion',
//        ],
//    ]) 
    ?>    
    <?php
    echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        //'heading'=>'Book # ' . $model->id,
        'heading'=>'Para editar las opciones, haga click en los siguientes íconos:',
        'type'=>DetailView::TYPE_WARNING,
    ],
    'attributes'=>[
//        'id',
        'radio',
//        'dia_pago_mensajeros',
        'envios_tomados_por_dia',
        'tiempo_refresco',
        'frec_almacenamiento_stand_by',
        'frec_envio_stand_by',
        'frec_almacenamiento_reparto',    
        'frec_envio_reparto',

        ['attribute'=>'foto_promocion', 'type'=>DetailView::INPUT_FILE],
    ]
]);
?>
</div>
</center>


<style>
    .opciones-view{
        width:75%;
    }
</style>    