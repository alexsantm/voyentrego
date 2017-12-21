<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Destino */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $id_usuario = Yii::$app->user->identity['id']; ?>

    <div class="col-lg-12">
            <input id="searchInput" class="controls" type="text" placeholder="Ingrese una dirección destino (Ej. Parque la Carolina)" required>
            <div id="map"></div>
            <ul id="geoData">
                <li>Full Address: <span id="location"></span></li>
                <li>Postal Code: <span id="postal_code"></span></li>
                <li>Country: <span id="country"></span></li>
                <li>Latitude: <span id="lat"></span></li>
                <li>Longitude: <span id="lon"></span></li>
            </ul>
    </div>

<div class="col-lg-12">
        <div class="geo-destino-form">
                <?php $form = ActiveForm::begin(); ?>        
                <div class="col-lg-4"><?= $form->field($model, 'ciudad_id')->dropDownList(ArrayHelper::map(app\models\Ciudad::find()->all(), 'id', 'ciudad'),  ['prompt' => '--Seleccione una Ciudad--'])->label('Ciudad')?></div>
                <div class="col-lg-4"><?= $form->field($model, 'direccion_destino')->textInput(['maxlength' => true]) ?></div>
                <div class="col-lg-4"><?= $form->field($model, 'destinatario')->textInput(['maxlength' => true]) ?></div>            
                <div class="col-lg-4"><?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?></div>
                <div class="col-lg-4"><?= $form->field($model, 'tipo_envio_id')->dropDownList(ArrayHelper::map(app\models\TipoEnvio::find()->all(), 'id', 'tipo_envio'),  ['prompt' => '--Seleccione una Tipo de Envìo--'])->label('Tipo de Envio')?></div>
                <div class="col-lg-4"><?= $form->field($model, 'dimensiones_id')->dropDownList(ArrayHelper::map(app\models\Dimensiones::find()->all(), 'id', 'dimension'),  ['prompt' => '--Seleccione una Dimensión--'])->label('Dimensiones')?></div>            
                
                <!--<input type="checkbox" id="manual" name="manual" value="0">¿Retorno?<br>-->
<!--                <form action="">
                    <input type="radio" name="destino" id="destino" value="destino"> Retorno Destino<br>
                    <input type="radio" name="inicio" id="inicio" value="inicio"> Retorno Inicio<br>
                </form>-->             
                <div class="col-lg-12">
                    <fieldset class="retorno">
                      <legend class="retorno_legend">Retorno</legend>
                      <p>Seleccione una opción:</p>
                            <!--<div class="col-lg-6"><?php // $form->field($model, 'destino_opc')->radioList(array('1'=>'Elegir Destino','2'=>'Retorna al Origen', '3'=>'Sin retornos'))->label(false); ?></div>-->                                
                            <?php $model->destino_opc = 1; ?> 
                            <div class="col-lg-7"><?= $form->field($model, 'destino_opc')->radioList(array('1'=>'Sin retornos', '2'=>'Elegir Destino','3'=>'Retorna al Origen', ))->label(false); ?></div>                                
                            <div class="col-lg-5"><?= $form->field($model, 'retorno_destino_id')->dropDownList(ArrayHelper::map(app\models\Destino::find()
                                    ->where(['envio_id'=>$id_envio])
                                    ->all(), 'id', 'direccion_destino'), 
                                    ['prompt' => '--Escoga un lugar de retorno--'])->label('Destino de Retorno');?>
                                    <?= $form->field($model, 'retorno_inicio')->checkbox(['uncheck' => 'NO', 'checked' => 1])->label (false); ?>
                            </div>                        
                    </fieldset>                   
                </div>
                                
                <div class="col-lg-12"><?= $form->field($model, 'observacion')->label('Observación:')->widget(CKEditor::className(), [
                          'options' => ['rows' => 1],
                         // 'options' => ['placeholder' => 'Ajuste el número de copias ...'],
                          'preset' => 'basic','clientOptions' => [
                              'allowedContent' => true,
                          ],])?>
                </div>	

            <!--//Campos Ocultos-->        
                    <?= $form->field($model, 'envio_id')->hiddenInput(['value'=>$id_envio])->label(false) ?>
                    <?= $form->field($model, 'latitud')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'longitud')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'kilometros')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'valor')->hiddenInput()->label(false) ?>            
        
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <center><?= Html::submitButton($model->isNewRecord ? 'Registrar Destino' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-warning btn-lg' : 'btn btn-primary']) ?></center>
                    </div>
                </div>
            </div> 
            <?php ActiveForm::end(); ?>
        </div>
</div>    

<?php $this->registerJsFile('@web/js/mapa.js',['depends' => [\yii\web\JqueryAsset::className()]]);?>
 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8&libraries=places&callback=initMap" async defer></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>-->

<style>
    #map {
    width: 100%;
    height: 400px;
}
.controls {
    margin-top: 10px;
    border: 1px solid transparent;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    height: 32px;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}
#searchInput {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 50%;
}
#searchInput:focus {
    border-color: #4d90fe;
}

#geoData{
    display: none;
}

/*Oculto campos*/
.field-destino-retorno_destino_id, .field-destino-retorno_inicio{
    display:none;
}

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
//Validacion de Dirección    
    $('form').submit(function () {
    // Get the Login Name value and trim it
    var direccion = $.trim($('#searchInput').val());

    // Check if empty of not
    if (direccion  === '') {
        alert('Por favor ingrese una direccion Destino.');
        return false;
    }
});
</script>    


<script>
$(document).ready(function () {
     $('input[name="Destino[destino_opc]"]').change(function () {
         if ($.trim($(this).val()) == "1") {
               $('.field-destino-retorno_inicio').hide();
               $('.field-destino-retorno_destino_id').hide();
               $('#destino-retorno_destino_id').val('');
               $('#destino-retorno_inicio').val('');             
          }
          //else {
          else if ($.trim($(this).val()) == "2") {    
              $('.field-destino-retorno_destino_id').show();
              $('.field-destino-retorno_inicio').hide();
              $('#destino-retorno_inicio').attr('checked', false);       
          }
          else if ($.trim($(this).val()) == "3") {    
               $('.field-destino-retorno_inicio').show();
               $('.field-destino-retorno_destino_id').hide();
               $('#destino-retorno_destino_id').val('');
          }
      });
});
</script>