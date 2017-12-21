<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Opciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="opciones-form">

    <?php $form = ActiveForm::begin([
            'id' => 'opciones',
            'enableClientValidation'=>true,
            'options' => [ 'enctype' => 'multipart/form-data']
    ]); ?>  

    <?= $form->field($model, 'radio')->textInput(['maxlength' => true]) ?>
    
    

    <?php // $form->field($model, 'dia_pago_mensajeros')->textInput() ?>

    <?= $form->field($model, 'envios_tomados_por_dia')->textInput() ?>

    <?php 
    echo $form->field($model, 'foto_promocion')->widget(\kartik\widgets\FileInput::classname(), [
        'options' => ['multiple' => false],
        'pluginOptions' => [
            'browseClass' => 'btn btn-warning',  
            'showUpload' => false,
            'showPreview' => false,
            'initialCaption'=> $model->foto_promocion,
        ],
    ])->hint("Debe adjuntar una fotografia para la promoción"); 
    ?>
    
    <?= $form->field($model, 'tiempo_refresco')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'frec_almacenamiento_stand_by')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'frec_envio_stand_by')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'frec_almacenamiento_reparto')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'frec_envio_reparto')->textInput(['maxlength' => true]) ?>  
        
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
