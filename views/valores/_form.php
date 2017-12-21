<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Valores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="valores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'km_inicio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'km_fin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
