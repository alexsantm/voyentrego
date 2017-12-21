<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DatosVehiculo */
/* @var $form yii\widgets\ActiveForm */
$user_id = Yii::$app->user->identity['id'];
?>

<div class="datos-vehiculo-form">

    <?php //$form = ActiveForm::begin(); ?>
    <?php $form = ActiveForm::begin(['method' => 'post', 'action' => Url::to(['/datos-vehiculo/createadminflota'])]); ?>

    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio')->textInput() ?>

    <?= $form->field($model, 'placa')->textInput(['maxlength' => true]) ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
