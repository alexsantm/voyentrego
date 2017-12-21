<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlanesRecarga */

$this->title = 'Actualizar Plan de Recarga: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Planes Recargas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="planes-recarga-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
