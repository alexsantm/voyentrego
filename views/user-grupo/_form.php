<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\UserGrupo */
/* @var $form yii\widgets\ActiveForm */

$user_id = Yii::$app->user->identity['id'];
?>

<div class="user-grupo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'user_id')->label('Seleccione un Usuario:')
        ->dropDownList(
                    ArrayHelper::map(amnah\yii2\user\models\User::find()->where(['responsable_id'=>$user_id])
                    ->all(),'id','username')
                    ,['prompt' => '--Seleccione el Usuario--']) 
    ?>	

    <?php // $form->field($model, 'grupo_usuarios_id')->textInput() ?>
    <?= $form->field($model, 'grupo_usuarios_id')->label('Seleccione un Grupo:')
        ->dropDownList(
                    ArrayHelper::map(app\models\GrupoUsuarios::find()->where(['responsable_user_id'=>$user_id])
                    ->all(),'id','grupo')
                    ,['prompt' => '--Seleccione el Grupo--']) 
    ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
