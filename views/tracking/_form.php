<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Envio */
/* @var $form yii\widgets\ActiveForm */
?>
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">Nuevo Tracking</h3>
        </div>
        <div class="panel-body">
        <!--/*******************************************************************************************************************************/-->    
            <div class="envio-form">
                <div class="row">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-lg-5">
                            <?= $form->field($model, 'user_id')->label('Seleccione una Categoría:')
                                ->dropDownList(
                                            ArrayHelper::map(\amnah\yii2\user\models\User::find()->where(['role_id'=>3])
                                            ->all(),'id','username')
                                            ,['prompt' => '--Seleccione una Prioridad--']) 
                            ?>	
                    </div>        
                </div>
                
                    <div class="col-lg-7">
                        <?php
                        echo $form->field($model, 'address')->widget(\kalyabin\maplocation\SelectMapLocationWidget::className(), [
                            'attributeLatitude' => 'latitude',
                            'attributeLongitude' => 'longitude',
                            'googleMapApiKey' => 'AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8',
                        ])->label('Ubicación en el Mapa: ');
                        ?>
                    </div> 
                
                
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <center><?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-primary']) ?></center>
                                </div>
                            </div>
                        </div>    
                    <?php ActiveForm::end(); ?>
            </div>
        <!--/*******************************************************************************************************************************/-->    
        </div>
    </div>
