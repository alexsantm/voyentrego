<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TipoEnvio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-envio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo_envio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
