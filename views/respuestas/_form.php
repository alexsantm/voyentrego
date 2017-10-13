<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Respuestas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="respuestas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'respuesta')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'preguntas_frecuentes_id')->hiddenInput(['value'=>$preguntas_frecuentes_id])->label(false) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
