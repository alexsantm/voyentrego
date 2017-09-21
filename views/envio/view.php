<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Envio */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="envio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ciudad_id',
            'user_id',
            'remitente',
            'direccion_origen',
            'latitud',
            'longitud',
            'celular',
            'fecha_registro',
            'fecha_fin_envio',
            'total_km',
            'valor_total',
            'observacion',
            'estado_envio_id',
            'tipo_envio_id',
            'dimensiones_id',
            'mensajero_id',
        ],
    ]) ?>

</div>
