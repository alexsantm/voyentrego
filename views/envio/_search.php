<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnvioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="envio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ciudad_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'remitente') ?>

    <?= $form->field($model, 'direccion_origen') ?>

    <?php // echo $form->field($model, 'latitud') ?>

    <?php // echo $form->field($model, 'longitud') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'fecha_registro') ?>

    <?php // echo $form->field($model, 'fecha_fin_envio') ?>

    <?php // echo $form->field($model, 'total_km') ?>

    <?php // echo $form->field($model, 'valor_total') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'estado_envio_id') ?>

    <?php // echo $form->field($model, 'tipo_envio_id') ?>

    <?php // echo $form->field($model, 'dimensiones_id') ?>

    <?php // echo $form->field($model, 'mensajero_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
