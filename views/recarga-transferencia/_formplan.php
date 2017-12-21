<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
               <?php
               $query = (new \yii\db\Query())
                ->select(['id', 'cast(valor as UNSIGNED) as valor', 'cast(valor_promo as UNSIGNED) as valor_promo'])
                ->from('planes_recarga')->all();
               ?>
            <div class="panel panel-warning">
                <div class="panel-heading"><span class="texto_tomate">Seleccione su Plan:</span></div>
                <div class="panel-body"> 
                    <center>
                        <?php $model->plan = 1; ?>   
                        <?= Html::activeRadioList($model, 'plan', ArrayHelper::map($query, 'id', 'valor')) ?>    
                    </center>    
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
    <?= $form->field($model, 'valor')->hiddenInput(['value'=>0],['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$user_id])->label(false) ?>

    <div class="form-group">
        <center><?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning btn-lg' : 'btn btn-primary btn-lg']) ?></center>
    </div>

    <?php ActiveForm::end(); ?>

</div>
