<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HistorialPagos */

$this->title = 'Update Historial Pagos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Historial Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historial-pagos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
