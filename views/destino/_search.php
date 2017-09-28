<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DestinoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destino-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ciudad_id') ?>

    <?= $form->field($model, 'envio_id') ?>

    <?= $form->field($model, 'destinatario') ?>

    <?= $form->field($model, 'direccion_destino') ?>

    <?php // echo $form->field($model, 'latitud') ?>

    <?php // echo $form->field($model, 'longitud') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <?php // echo $form->field($model, 'fecha_asignacion') ?>

    <?php // echo $form->field($model, 'fecha_finalizacion') ?>

    <?php // echo $form->field($model, 'kilometros') ?>

    <?php // echo $form->field($model, 'valor') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'estado_envio_id') ?>

    <?php // echo $form->field($model, 'retorno_destino_id') ?>

    <?php // echo $form->field($model, 'retorno_inicio') ?>

    <?php // echo $form->field($model, 'tipo_envio_id') ?>

    <?php // echo $form->field($model, 'dimensiones_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
