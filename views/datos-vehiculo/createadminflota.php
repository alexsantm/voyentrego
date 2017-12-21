<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DatosVehiculo */

$this->title = 'Nuevo Vehiculo';
$this->params['breadcrumbs'][] = ['label' => 'Datos Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="datos-vehiculo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formadminflota', [
        'model' => $model,
    ]) ?>

</div>
