<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
//use yii\jui\DatePicker;
//use kartik\date\DatePicker;
//use kartik\widgets\DateTimePicker;
use kartik\date\DatePicker;
use yii\helpers\Url;
use kartik\widgets\Select2;

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
                    <div class="col-lg-6">
                        <?php
                        echo $form->field($model, 'address')->widget(\kalyabin\maplocation\SelectMapLocationWidget::className(), [
                            'attributeLatitude' => 'latitude',
                            'attributeLongitude' => 'longitude',
                            'googleMapApiKey' => 'AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8',
                        ])->label('Ubicación en el Mapa: ');
                        ?>
                    </div> 
                    
                    <div class="col-lg-6">
                        <div class="col-lg-4"><?= $form->field($model, 'ciudad_id')->dropDownList(ArrayHelper::map(app\models\Ciudad::find()->all(), 'id', 'ciudad'),  ['prompt' => '--Seleccione una Ciudad--'])->label('Ciudad')?></div>                
                        <div class="col-lg-4"><?= $form->field($model, 'direccion_origen')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-lg-4"><?= $form->field($model, 'remitente')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-lg-4"><?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>  </div>          
                        <div class="col-lg-4"><?= $form->field($model, 'tipo_envio_id')->dropDownList(ArrayHelper::map(app\models\TipoEnvio::find()->all(), 'id', 'tipo_envio'),  ['prompt' => '--Seleccione una Tipo de Envìo--'])->label('Tipo de Envio')?></div>
                        <div class="col-lg-4"><?= $form->field($model, 'dimensiones_id')->dropDownList(ArrayHelper::map(app\models\Dimensiones::find()->all(), 'id', 'dimension'),  ['prompt' => '--Seleccione una Dimensión--'])->label('Dimensiones')?> </div>   
                        <div class="col-lg-12">
                                <?= $form->field($model, 'observacion')->label('Observación:')->widget(CKEditor::className(), [
                                          'options' => ['rows' => 1],
                                         // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                                          'preset' => 'basic','clientOptions' => [
                                              'allowedContent' => true,
                                          ],])
                                ?>	
                        </div> 
                    <fieldset class="retorno">
                        <legend class="retorno_legend"><strong>Programación Recurrente</strong></legend>
                        <small>Escoga una fecha de inicio y fin, y seleccione el o los dias en los que se programarán los envíos</small>
                        <div class="row"><br>
                            <div class="col-lg-12">
                                    <?php
                                        echo '<label class="control-label">Ingrese una fecha de inicio y fin</label><br>';
                                        echo DatePicker::widget([
                                            'name' => 'fecha_desde',
                                            'type' => DatePicker::TYPE_RANGE,
                                            'name2' => 'fecha_hasta',
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd',
                                                'required' => true
                                            ]
                                        ]);
                                        ?>

                                    <?php
                                    // Without model and implementing a multiple select
                                    $data =   [ 1 => 'Lunes',2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves',5 => 'Viernes', 6 => 'Sábado',7 => 'Domingo',];
                                    echo '<br><label class="control-label">Seleccione el o los días</label>';
                                    echo Select2::widget([
                                        'name' => 'dias',
                                        'data' => $data,
                                        'options' => [
                                            'placeholder' => 'Selecione el/los dias ...',
                                            'multiple' => true,
                                            'required' => true
                                        ],
                                    ]);
                                    ?>    
                            </div> 
                        </div>    
                     </fieldset>
                        
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
  
                </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <br><center><?= Html::submitButton($model->isNewRecord ? 'Registrar Origen' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-warning btn-lg' : 'btn btn-primary']) ?></center>
                                </div>
                            </div>
                        </div>    
                    <?php ActiveForm::end(); ?>
            </div>
        <!--/*******************************************************************************************************************************/-->    
        </div>
    </div>

<style>
    fieldset.retorno {
    border: solid 1px #DDD !important;
    padding: 0 10px 10px 10px;
    border-bottom: none;
}

legend.retorno_legend {
    width: auto !important;
    border: none;
    font-size: 14px;
}
</style>    

<script>
    document.getElementById("envio-address").required = true;    
</script>  