<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DatosBancariosMensajero */

//Captura variable $flag y la envio al formulario

$this->title = 'Cambio a Pago con Cheque ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pago con Cheque', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="datos-bancarios-mensajero-update">
    

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcheque', [
        'model' => $model,
        'flag' => $flag,
    ]) ?>

</div>
