<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OpcionesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="opciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'radio') ?>

    <?= $form->field($model, 'dia_pago_mensajeros') ?>

    <?= $form->field($model, 'envios_tomados_por_dia') ?>

    <?= $form->field($model, 'foto_promocion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
