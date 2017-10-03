<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecargaTransferencia */

$this->title = 'Create Recarga Transferencia';
$this->params['breadcrumbs'][] = ['label' => 'Recarga Transferencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recarga-transferencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
