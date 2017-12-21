<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReporteProblemaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reporte-problema-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'envio_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'problema_id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?php // echo $form->field($model, 'imagen') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
