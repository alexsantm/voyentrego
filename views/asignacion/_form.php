<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Asignacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignacion-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(app\models\Role::find()->all(), 'id', 'name'),  ['prompt' => '--Seleccione un Rol--'])->label('Rol')?>

    <?= $form->field($model, 'ruta_id')->dropDownList(ArrayHelper::map(app\models\Ruta::find()->all(), 'id', 'ruta'),  ['prompt' => '--Seleccione una Ruta--'])->label('Ruta')?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
