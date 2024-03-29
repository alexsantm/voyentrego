<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PreguntasFrecuentes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preguntas-frecuentes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pregunta_frecuente')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'fecha')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
