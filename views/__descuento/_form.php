<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\widgets\DateTimePicker;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Descuento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="descuento-form">
<?php 
//Codigo Aleatorio
  $model = new \app\models\Descuento;
  $variable = $model->generarCodigo(10);
//  print_r($variable);
?>
    <?php $form = ActiveForm::begin(['options' => [ 'enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'codigo_descuento')->textInput(['value' => $variable]) ?>
    <?= $form->field($model, 'valor_descuento')->textInput(['maxlength' => true]) ?>    

    <?=  '<label class="control-label">Rango de la Promoción</label>';
        echo DatePicker::widget([
            'name' => 'fecha_inicio',
//            'value' => '01-Feb-1996',
            'type' => DatePicker::TYPE_RANGE,
            'name2' => 'fecha_fin',
//            'value2' => '27-Feb-1996',
            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
    ?>
    
    <?= $form->field($model, 'archivo_promocion')->widget(\kartik\widgets\FileInput::classname(), [
        'options' => ['multiple' => false],
        'pluginOptions' => [
            'showUpload' => false,
            'initialCaption'=> $model->archivo_promocion,
        ],
    ]); 
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
