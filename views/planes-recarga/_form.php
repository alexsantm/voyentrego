<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlanesRecarga */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planes-recarga-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'valor')->textInput(['maxlength' => true])->label('Valor del Plan de Recarga') ?>

    <?= $form->field($model, 'valor_promo')->textInput(['maxlength' => true])->label('Valor de la Promoción') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
