<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
//use kartik\detail\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DatosBancariosMensajero */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Datos Bancarios Mensajeros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
//print_r(Yii::$app->request->get()); die();
$id_usuario = Yii::$app->user->identity['id']; 

?>
<div class="datos-bancarios-mensajero-view">

    <h1><?= Html::encode($this->title) ?></h1>    
    <?php
    $query = \app\models\DatosBancariosMensajero::find()->where(['user_id'=>$id_usuario])->asArray()->one();
    $tipo_pago = $query['tipo_transferencia'];
    if(!empty($tipo_pago)){
    ?>
            <div class="alert alert-info">Su tipo de pago actual es: <strong><?= $tipo_pago;?></strong></div>
    <?php
    }
    else{
    ?>
            <div class="alert alert-warning"><h4>Usted aún no registra un método para la cancelación de sus honoriarios. Por favor registre uno seleccionando el método de pago</h4></div>
     <?php
    }
    ?>        
                  <div class="panel panel-default">
                      <div class="panel-heading"><center><h2>Seleccione un mètodo de Pago</h2></center></div>
                      <div class="panel-body"><center>
                            <?php $form = ActiveForm::begin(); ?>     
                                <?= $form->field($model, 'tipo')->radioList(array('CHEQUE'=>'Cheque','TRANSFERENCIA'=>'Transferencia'))->label(false); ?>
                            <?php ActiveForm::end(); ?>
                      </center></div>
                   </div>   
                
    <div class="transferencia">
                    <br><br><br><p>  
                        <?php
                        $query = \app\models\DatosBancariosMensajero::find()->where(['user_id'=>$id_usuario])->asArray()->count();
                        if($query == 0){                           
                            ?><center><?= Html::a('Añadir datos de Cuenta Bancaria', ['//datos-bancarios-mensajero/create'], ['class' => 'btn btn-success modalButton']) ?></center><?php       
                        }
                        else if($query > 0){
                            $model = new \app\models\DatosBancariosMensajero;
                            $query = \app\models\DatosBancariosMensajero::find()->where(['user_id'=>$id_usuario])->asArray()->one();
                            $id = $query['id'];                            
                            ?><?= Html::a('Cambiar datos de Cuenta Bancaria', ['//datos-bancarios-mensajero/update', 'id' => $id], ['class' => 'btn btn-primary modalButton']) ?><?php
                        }
                        ?>
                    </p>
                    
                    <?php
                    //Creo un nuevo modelo para pasarlo al DetailView
                     $model_transf = \app\models\DatosBancariosMensajero::find()->where(['user_id'=>$id_usuario])->asArray()->one();
                     
                     if(!empty($model_transf)){
                    ?>
                    
                    <?= DetailView::widget([
                        'model'=>$model_transf,
//                        'condensed'=>true,
//                        'hover'=>true,
//                        'mode'=>DetailView::MODE_VIEW,
//                        'panel'=>[
//                            'heading'=>'Datos Bancarios ' . $model->id,
//                            'type'=>DetailView::TYPE_WARNING,
//                        ],        
                        //'model' => $model,
                        'attributes' => [
//                            'id',
//                            'user_id',
                            'numero_cuenta',
//                            'tipo_transferencia',
                            'nombre_banco',
                            'nombre_completo',
                            'identificacion',
                            'email:email',
//                            'fecha',
                        ],
                    ]) ;
                     }       ?>
    </div>  
    
    <div class="cheque col-lg-4 col-lg-offset-4">
        <br><br>
        <?php
        $id_usuario = Yii::$app->user->identity['id'];
        $model = new \app\models\DatosBancariosMensajero;
        $query = \app\models\DatosBancariosMensajero::find()->where(['user_id'=>$id_usuario])->asArray()->count();
                        if($query == 0){
                            echo $cheque = $this->context->renderPartial('//datos-bancarios-mensajero/createcheque', ['model'=>$model]);
                        }
                       else if($query > 0){
                            $query = \app\models\DatosBancariosMensajero::find()->where(['user_id'=>$id_usuario])->asArray()->one();
                            $id = $query['id'];
                            $flag = 'SI'; 
                            $model = \app\models\DatosBancariosMensajero::findOne($id);
                            echo $this->render('updatecheque', ['model' => $model,  'flag'=>$flag]);
                       }      
                       else{
                           print_r("otra"); die();
                       }
        ?>
    </div>
</div> 

<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-xs',
		'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
    ]);
        echo "<div class='modalContent'></div>";
    yii\bootstrap\Modal::end();

        $this->registerJs(
        "$(document).on('ready pjax:success', function() {
                $('.modalButton').click(function(e){
                   e.preventDefault(); //for prevent default behavior of <a> tag.
                   var tagname = $(this)[0].tagName;
                   $('#editModalId').modal('show').find('.modalContent').load($(this).attr('href'));
               });
            });
        ");
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function () {
    $('.transferencia').hide();
    $('.cheque').hide();
     $('input[name="DatosBancariosMensajero[tipo]"]').change(function () {
         if ($.trim($(this).val()) == "CHEQUE") {
             $('.transferencia').hide();
             $('.cheque').show();
//              $('.field-destino-retorno_destino_id').show();
//              $('.field-destino-retorno_inicio').hide();
//              $('#destino-retorno_inicio').attr('checked', false);              
          }
          else {
              $('.transferencia').show();
              $('.cheque').hide();
//               $('.field-destino-retorno_inicio').show();
//               $('.field-destino-retorno_destino_id').hide();
//               $('#destino-retorno_destino_id').val('');
          }
      });
});
</script>