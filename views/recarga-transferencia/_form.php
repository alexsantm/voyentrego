<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\RecargaTransferencia */
/* @var $form yii\widgets\ActiveForm */
$user_id = Yii::$app->user->identity['id'];
?>

<div class="recarga-transferencia-form">
    <?php $form = ActiveForm::begin([
            'id' => 'recarga',
            'enableClientValidation'=>true,
            'options' => [ 'enctype' => 'multipart/form-data']
    ]); ?>        
        <div class="panel panel-info">
            <div class="panel-heading">Ingrese el código de Promoción (opcional)</div>
            <div class="panel-body">
               <?php // $form->field($model, 'codigo_promocion')->textInput(['maxlength' => true]) ?>
               <?= $form->field($model, 'codigo_promocion', ['enableAjaxValidation' => true]); ?>
            </div>
        </div>  

    <?php 
    echo $form->field($model, 'doc_referencia')->widget(\kartik\widgets\FileInput::classname(), [
        'options' => ['multiple' => false],
        'pluginOptions' => [
            'browseClass' => 'btn btn-warning',  
            'showUpload' => false,
            'showPreview' => false,
            'initialCaption'=> $model->doc_referencia,
        ],
    ])->hint("Debe adjuntar el documento de pago de transferencia para hacerla efectiva"); 
    ?>
    <?= $form->field($model, 'valor')->textInput(['required'=>'required'],['maxlength' => true])->hint("Ingrese el valor a recargar. Debe ser acorde con el documento de pago de la Transferencia") ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$user_id])->label(false) ?>

    <div class="form-group">
        <center><?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning btn-lg' : 'btn btn-warning btn-lg']) ?></center>
    </div>

    <?php ActiveForm::end(); ?>
</div>
