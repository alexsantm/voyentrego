<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\Calificacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calificacion-form">
    <h3>Selecciona la calificación de tu mensajero y coloca una observación si es necesario</h3>

    <?php $form = ActiveForm::begin();?>
    
    <center><?php
    echo $form->field($model, 'calificacion')->widget(StarRating::classname(), [
    'name' => 'calificacion',
    'language' => 'es',
    'pluginOptions' => [
        'min' => 1,
        'max' => 6,
        'step' => 1,
        'size' => 'lg',
        'starCaptions' => [
            1 => 'Muy deficiente',
            2 => 'Deficiente',
            3 => 'Normal',
            4 => 'Muy bueno',
            5 => 'Excelente',            
        ],
        'starCaptionClasses' => [
            1 => 'text-danger',
            2 => 'text-danger',
            3 => 'text-warning',
            4 => 'text-info',
            5 => 'text-success',            
        ],
    ],
    ])->label('Califíca el servicio:');    
    ?>
    </center>    

    <?= $form->field($model, 'observacion')->label('Observación:')->widget(CKEditor::className(), [
          'options' => ['rows' => 1],
         // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
          'preset' => 'basic','clientOptions' => [
              'allowedContent' => true,
          ],])
    ?>
    
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$user_id])->label(false) ?>
    <?= $form->field($model, 'mensajero_id')->hiddenInput(['value'=>$mensajero_id])->label(false) ?>
    <?= $form->field($model, 'envio_id')->hiddenInput(['value'=>$envio_id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Calificar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
