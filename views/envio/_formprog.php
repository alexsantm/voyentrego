<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
//use yii\jui\DatePicker;
//use kartik\date\DatePicker;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Envio */
/* @var $form yii\widgets\ActiveForm */
?>
 <?php $id_usuario = Yii::$app->user->identity['id']; ?>
<ul>
    <p><strong>Instrucciones</strong></p>
    <li>Digite la ubicación en el campo "Ubicación en el Mapa"</li>
    <li>Movilice el Marcador hasta el punto de origen del envío</li>
    <li>Complete el formulario, colocando una descripción para el Envío en el campo "Dirección Origen"</li>
    <li>Seleccione una fecha y hora para completar el envío</li>
</ul>

    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">Nuevo Envío</h3>
        </div>
        <div class="panel-body">
        <!--/*******************************************************************************************************************************/-->    
            <div class="envio-form">
                <div class="row">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-lg-5">
                        <div class="col-lg-6"><?= $form->field($model, 'ciudad_id')->dropDownList(ArrayHelper::map(app\models\Ciudad::find()->all(), 'id', 'ciudad'),  ['prompt' => '--Seleccione una Ciudad--'])->label('Ciudad')?></div>                
                        <div class="col-lg-6"><?= $form->field($model, 'direccion_origen')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-lg-6"><?= $form->field($model, 'remitente')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-lg-6"><?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>  </div>          
                        <div class="col-lg-6"><?= $form->field($model, 'tipo_envio_id')->dropDownList(ArrayHelper::map(app\models\TipoEnvio::find()->all(), 'id', 'tipo_envio'),  ['prompt' => '--Seleccione una Tipo de Envìo--'])->label('Tipo de Envio')?></div>
                        <div class="col-lg-6"><?= $form->field($model, 'dimensiones_id')->dropDownList(ArrayHelper::map(app\models\Dimensiones::find()->all(), 'id', 'dimension'),  ['prompt' => '--Seleccione una Dimensión--'])->label('Dimensiones')?> </div>   
                        <div class="col-lg-12">
                                <?= $form->field($model, 'observacion')->label('Observación:')->widget(CKEditor::className(), [
                                          'options' => ['rows' => 1],
                                         // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                                          'preset' => 'basic','clientOptions' => [
                                              'allowedContent' => true,
                                          ],])
                                ?>	
                        </div> 
                        <div class="col-lg-12">
                        <?php
                             echo $form->field($model,'fecha_registro')->
                                widget(DateTimePicker::className(),[
                                'name' => 'fecha_registro',
                                'size' => 'lg',       
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd hh:ii'
                                ],
                                'options' => ['placeholder' => 'Haga click aquí para seleccionar una fecha ...'],    
                            ])->hint("Por favor escoga una fecha y una hora para programar el envío");
                        ?>
                        </div>    
                        
<!--                        echo '<label class="control-label">Inaugral Date</label>';
echo DateTimePicker::widget([
	'name' => 'inaugral_time',
	'value' => '01/04/2005 08:17',
	'size' => 'lg',
	'pluginOptions' => [
		'autoclose' => true,
		'format' => 'mm/dd/yyyy hh:ii'
	]
]);-->
                        
                        
                        
                        <!--//Parametrizar el Fecha Registro en el Controller-->
                        <!--//Parametrizar el Fecha fin Envio en el Controller-->
                        <!--//Parametrizar el EStado Envio en el Controller-->
                        <!--//Parametrizar el Mensajero Id en el Controller-->

                        <!--Campos Ocultos:-->
                        <?= $form->field($model, 'user_id')->hiddenInput(['value'=>$id_usuario])->label(false) ?>
                        <?= $form->field($model, 'latitud')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'longitud')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'total_km')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'valor_total')->hiddenInput()->label(false) ?>
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
                </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <center><?= Html::submitButton($model->isNewRecord ? 'Registrar Origen' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-primary']) ?></center>
                                </div>
                            </div>
                        </div>    
                    <?php ActiveForm::end(); ?>
            </div>
        <!--/*******************************************************************************************************************************/-->    
        </div>
    </div>

