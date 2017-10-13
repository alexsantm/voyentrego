<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Contactanos */
/* @var $form yii\widgets\ActiveForm */
?>
    <p>Si tienes comentarios, dudas, sugerencias o quieres reportar una queja, por favor completa el siguiente formulario
    y en la brevedad posible nos pondremos en contacto contigo.</p>
    <p>Gracias por utilizar Voyentrego</p>
<div class="row"> 
    <div class="col-lg-8 col-lg-offset-2"> 
        <div class="contactanos-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-lg-12"><?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?></div>
            <div class="col-lg-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
            <div class="col-lg-6"><?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?></div>
            <div class="col-lg-6"><?= $form->field($model, 'ciudad_id')->label('Ciudad:')->dropDownList(ArrayHelper::map(app\models\Ciudad::find()->all(),'id','ciudad'),['prompt' => '--Seleccione una Ciudad--'])?></div>
            <div class="col-lg-6"><?= $form->field($model, 'tipo_mensaje')->dropdownList(
                    ['Comentario' => 'Comentario', 'Sugerencia' => 'Sugerencia', 'Queja' => 'Queja'], 
                    ['prompt' => '-Selecione un Tipo-']) 
            ?>    </div>
            <div class="col-lg-12"><?= $form->field($model, 'mensaje')->label('Su mensaje:')->widget(CKEditor::className(), [
                                                  'options' => ['rows' => 1],
                                                 // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                                                  'preset' => 'basic','clientOptions' => [
                                                      'allowedContent' => true,
                                                  ],])
                                        ?></div>
            <div class="form-group">
                <center><?= Html::submitButton($model->isNewRecord ? 'Enviar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-lg btn-success' : 'btn btn-primary']) ?></center>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
   </div>     
</div>    
