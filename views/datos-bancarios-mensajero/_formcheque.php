<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DatosBancariosMensajero */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $id_usuario = Yii::$app->user->identity['id']; ?>

<div class="datos-bancarios-mensajero-form">
    <p>Seleccione Pago con cheque para registrar su método de cancelación de haberes</p>

    <?php 
//    $model->tipo_transferencia = 'CHEQUE';
//    $form = ActiveForm::begin([
//        'id' => 'login-form-inline', 
//        'type' => ActiveForm::TYPE_INLINE
//    ]);  
    ?>
    
    <?php
    
if(!empty($flag)){    
    $model->tipo_transferencia = 'CHEQUE';
    $form = ActiveForm::begin([
        'id' => 'login-form-inline', 
        'type' => ActiveForm::TYPE_INLINE,
        'method' => 'post',
        'action' => Url::to(['//datos-bancarios-mensajero/actualizarcheque']),
    ]);    
   ?>    
    <?= $form->field($model, 'id')->hiddenInput(['value'=>$model->id, 'readonly' => true]) ?>
    <div class="col-lg-6"><?= $form->field($model, 'tipo_transferencia')->radioList(array('CHEQUE'=>'Pago en Cheque'))->label(false); ?></div>
    
    <?= $form->field($model, 'numero_cuenta')->hiddenInput(['value'=>''])->label(false)  ?>
    <?= $form->field($model, 'nombre_banco')->hiddenInput(['value'=>''])->label(false) ?>
    <?= $form->field($model, 'nombre_completo')->hiddenInput(['value'=>''])->label(false) ?>
    <?= $form->field($model, 'identificacion')->hiddenInput(['value'=>''])->label(false) ?>
    <?= $form->field($model, 'email')->hiddenInput(['value'=>''])->label(false) ?>
    
    
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$id_usuario])->label(false) ?>

    <div class="form-group">    
        <div class="col-lg-6">
            <?php // Html::a('Guardar', Url::toRoute(['//datos-bancarios-mensajero/updatecheque', 'id' => $model->id]), ['class'=>'btn btn-primary'],['data-method' => 'post']) ?>
            <?=Html::submitButton($model->isNewRecord ? 'Registrar Datos con Flag' : 'Actualizar con Flag', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>    
        </div>
    </div>    

    <?php ActiveForm::end(); 
}    
else{
    $model->tipo_transferencia = 'CHEQUE';
     $form = ActiveForm::begin([
        'id' => 'login-form-inline', 
        'type' => ActiveForm::TYPE_INLINE,
        'method' => 'post',
        'action' => Url::to(['//datos-bancarios-mensajero/createcheque']),
    ]);    
   ?>
    <div class="col-lg-6"><?= $form->field($model, 'tipo_transferencia')->radioList(array('CHEQUE'=>'Pago en Cheque'))->label(false); ?></div>
    
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$id_usuario])->label(false) ?>
    <div class="form-group">
        <div class="col-lg-6">
            <?= Html::submitButton($model->isNewRecord ? 'Registrar Datos' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>    
    </div>

    <?php ActiveForm::end(); 
}
    ?>
</div>
