<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\PaginaVoyentrego */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pagina-voyentrego-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'texto')->label('Texto:')->widget(CKEditor::className(), [
        'options' => ['rows' => 5],
         // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
        'preset' => 'advanced',
        'clientOptions' => [
              'allowedContent' => true,
          ],])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>