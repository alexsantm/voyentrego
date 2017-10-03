<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecargaTransferencia */

$this->title = 'Update Recarga Transferencia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recarga Transferencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recarga-transferencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
