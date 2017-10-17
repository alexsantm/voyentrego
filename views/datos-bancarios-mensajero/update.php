<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DatosBancariosMensajero */

$this->title = 'Update Datos Bancarios Mensajero: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Datos Bancarios Mensajeros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="datos-bancarios-mensajero-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
