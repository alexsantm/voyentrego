<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Problema */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="problema-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'problema')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'buscar_mensajero')->textInput() ?>
    <?= $form->field($model, 'buscar_mensajero')->dropdownList([1 => 'SI', 0 => 'NO'], ['prompt' => '-Selecione Estado-']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
