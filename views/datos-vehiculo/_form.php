<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DatosVehiculo */
/* @var $form yii\widgets\ActiveForm */
$user_id = Yii::$app->user->identity['id'];
?>

<div class="datos-vehiculo-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id')->label('Seleccione un Usuario:')
        ->dropDownList(
                    ArrayHelper::map(amnah\yii2\user\models\User::find()->where(['responsable_id'=>$user_id])
                    ->all(),'id','username')
                    ,['prompt' => '--Seleccione el Usuario--']) 
    ?>	

    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio')->textInput() ?>

    <?= $form->field($model, 'placa')->textInput(['maxlength' => true]) ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
