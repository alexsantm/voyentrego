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
    
    <?php
     $usuarios_no_asignados = (new \yii\db\Query())
    ->select(["p.user_id", "p.full_name", "u.role_id"])
    ->from('profile p, user u, datos_vehiculo d') 
    ->where('not exists (select * from datos_vehiculo as l where l.user_id=p.user_id)')
    ->andWhere('u.id = p.user_id')
    ->andWhere('u.role_id = 3')
    ->groupBy('p.user_id')
    ->orderBy('p.full_name')
    ->all(); 

     
     if(empty($usuarios_no_asignados)){
        $usuarios_no_asignados = (new \yii\db\Query())
        ->select(["p.user_id", "p.full_name"])
        ->from('profile p, user u') 
        ->where('u.id = p.user_id')
        ->andWhere('u.role_id = 3')
        ->orderBy('p.full_name')
        ->all();
     }
          
    $data = ArrayHelper::map($usuarios_no_asignados, 'user_id', 'full_name');	
?>	
    <?= $form->field($model, 'user_id')->label('Seleccione un Mensajero:') ->dropDownList($data,['prompt' => '--Seleccione un Mensajero--'])?>

    <div class="col-lg-6"><?= $form->field($model, 'marca')->textInput(['maxlength' => true, 'readonly' => true]) ?></div>

    <div class="col-lg-6"><?= $form->field($model, 'modelo')->textInput(['maxlength' => true, 'readonly' => true]) ?></div>

    <div class="col-lg-6"><?= $form->field($model, 'anio')->textInput(['readonly' => true]) ?></div>

    <div class="col-lg-6"><?= $form->field($model, 'placa')->textInput(['maxlength' => true, 'readonly' => true]) ?></div>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Asignar Vehículo', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
