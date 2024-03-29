<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Envio */

$this->title = 'Update Envio: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="envio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formprog', [
        'model' => $model,
    ]) ?>

</div>
