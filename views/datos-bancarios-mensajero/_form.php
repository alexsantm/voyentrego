<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DatosBancariosMensajero */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $id_usuario = Yii::$app->user->identity['id']; ?>

<div class="datos-bancarios-mensajero-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class='row'>
        <div class="col-lg-6">
            <?= $form->field($model, 'tipo_transferencia')->textInput(['value'=>'TRANSFERENCIA', 'readonly' => true]) ?>
        </div>
        <div class="col-lg-6"><?= $form->field($model, 'numero_cuenta')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-6"><?= $form->field($model, 'nombre_banco')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-6"><?= $form->field($model, 'nombre_completo')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-6"><?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
    </div>
    
    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$id_usuario])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Añadir' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
