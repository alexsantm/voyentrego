<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecargaTransferencia */

$this->title = 'Recargar Saldo con Planes de Recarga';
$this->params['breadcrumbs'][] = ['label' => 'Recarga Transferencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recarga-transferencia-create">
    

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Seleccione el plan que mas le interese, y a continuación, adjunte una captura de pantalla del depósito o transferencia.
        Una vez validado el documento se acreditará su recarga a su Saldo
    </p>

    <?= $this->render('_formplan', [
        'model' => $model,
    ]) ?>

</div>



                 
                 
                 
