<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecargaTransferencia */

$this->title = 'Recargar Saldo';
$this->params['breadcrumbs'][] = ['label' => 'Recarga Transferencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recarga-transferencia-create">
    

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Para recarga Saldo a su cuenta, adjunte una captura de pantalla del depósito o transferencia
    y digite el valor a recargar. Una vez validado el documento se acreditará su recarga a su Saldo
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
