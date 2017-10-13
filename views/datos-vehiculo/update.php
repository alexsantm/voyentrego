<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DatosVehiculo */

$this->title = 'Update Datos Vehiculo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Datos Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="datos-vehiculo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
