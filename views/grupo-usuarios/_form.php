<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GrupoUsuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupo-usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'grupo')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'responsable_user_id')->textInput() ?>

    <?php // $form->field($model, 'fecha')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
