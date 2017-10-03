<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CalificacionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calificacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'calificacion') ?>

    <?= $form->field($model, 'observacion') ?>

    <?= $form->field($model, 'mensajero_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'envio_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
