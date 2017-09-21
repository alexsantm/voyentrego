<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoEnvio */

$this->title = 'Update Tipo Envio: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-envio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
