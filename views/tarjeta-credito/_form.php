<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TarjetaCredito */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tarjeta-credito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'creditCard_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'creditCard_expirationDate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'creditCard_cvv')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
//use yii\bootstrap\ActiveForm;
use andrewblake1\creditcard\CreditCardNumber;
use andrewblake1\creditcard\CreditCardExpiry;
use andrewblake1\creditcard\CreditCardCVCode;
?>

<?php $form = ActiveForm::begin() ?>
    <div class="container">
        <div id="card" class="row">
            <div class="col-xs-7">
                <?= $form->field($model, 'creditCard_number')->widget(CreditCardNumber::className(), ['submit' => false,]) ?>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, 'creditCard_expirationDate')->widget(CreditCardExpiry::className(), ['submit' => false,]) ?>
            </div>
            <div class="col-xs-2">
                <?= $form->field($model, 'creditCard_cvv')->widget(CreditCardCVCode::className(), ['submit' => false,]) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>






   <?php $form = \tuyakhov\braintree\ActiveForm::begin() ?>
    <?= $form->field($model, 'creditCard_number'); ?>
    <?= $form->field($model, 'creditCard_cvv'); ?>
    <?= $form->field($model, 'creditCard_expirationDate')->widget(\yii\widgets\MaskedInput::className(), [
           'mask' => '99/9999',
       ]) ?>
    <?= $form->field($model, 'amount'); ?>
    <?= \yii\helpers\Html::submitButton()?>
    <?php \tuyakhov\braintree\ActiveForm::end(); ?>