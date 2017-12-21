<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\StatusMensajero */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="status-mensajero-form">

        <?php $form = ActiveForm::begin([
            'id' => 'recarga',
            'enableClientValidation'=>true,
            'options' => [ 'enctype' => 'multipart/form-data']
    ]); ?> 

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

        <?php 
    echo $form->field($model, 'icono')->widget(\kartik\widgets\FileInput::classname(), [
        'options' => ['multiple' => false],
        'pluginOptions' => [
            'browseClass' => 'btn btn-warning',  
            'showUpload' => false,
            'showPreview' => false,
            'initialCaption'=> $model->icono,
        ],
    ])->hint("Debe adjuntar una imagen para el icono"); 
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
