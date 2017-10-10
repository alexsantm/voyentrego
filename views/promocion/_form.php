<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Promocion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promocion-form">
    <?php
    //Codigo Aleatorio
  $model = new \app\models\Promocion;
  $variable = $model->generarCodigo(10);
//  print_r($variable);
    ?>
    

    <?php $form = ActiveForm::begin(); ?>
<div class="row">  
    <div class="col-lg-6 col-lg-offset-3">
            <div class="col-lg-6"><?= $form->field($model, 'codigo_promocion')->textInput(['value' => $variable]) ?></div>
            <div class="col-lg-6"><?= $form->field($model, 'valor_promocion')->textInput(['maxlength' => true]) ?></div>
            <div class="col-lg-6"><?= $form->field($model, 'valor_base')->textInput(['maxlength' => true]) ?></div>
            <div class="col-lg-6"><?= $form->field($model, 'limite')->textInput() ?></div>
            <div class="col-lg-12"><?=  '<label class="control-label">Rango de la Promoción</label>';
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
            ?></div>
   </div>  
</div><br><br>
<div class="row">     
    <center><div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar Promoción' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div></center>
   

    <?php ActiveForm::end(); ?>
</div> 
</div>
