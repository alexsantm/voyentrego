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
//            'id' => 'recarga',
//            'enableAjaxValidation' => true,
//            'enableClientValidation'=>true,
//            'enableAjaxValidation'=>true,
//            'validateOnSubmit' => true,
//            'validateOnBlur' => true,
//            'validateOnChange' => true,
//            'validationUrl'=> Url::toRoute('RecargaTransferencia/validation'),
            'options' => [ 'enctype' => 'multipart/form-data']
    ]); ?>
        
         <div class="panel panel-default">
         <div class="panel-heading">Ingrese el código de Promoción (opcional)</div>
         <div class="panel-body">
            <?php // $form->field($model, 'codigo_promocion')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'codigo_promocion', ['enableAjaxValidation' => true]); ?>
         </div>
     </div>  

    <?php 
    echo $form->field($model, 'doc_referencia')->widget(\kartik\widgets\FileInput::classname(), [
//        'model' => $model,
//        'name' => 'doc_referencia',
        'options' => ['multiple' => false],
        'pluginOptions' => [
//            'previewFileType' => 'image',
            'showUpload' => false,
            'showPreview' => false,
//            'initialPreview'=> [
//                '<img src="'.$model->path.'" class="file-preview-image">',
//            ],
            'initialCaption'=> $model->doc_referencia,
        ],
    ]); 
    ?>
    <?= $form->field($model, 'valor')->textInput(['required'=>'required'],['maxlength' => true]) ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$user_id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
