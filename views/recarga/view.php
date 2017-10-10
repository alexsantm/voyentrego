<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recarga */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recargas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    
        <div class="user-default-profile col-lg-12">
         <div class="panel panel-default">
             <div class="panel-body">
                                  
                 <div class="row">
                        <div class="col-lg-6">
                             <h1 class="texto_tomate">Recargas</h1>
                        </div>

                        <div class="col-lg-6">
                                    <?php
                                       $query = \app\models\Recarga::find()->select(['valor_recarga'])->where(['user_id'=> $user_id])->asArray()->one();
                                       $valor_recarga = $query['valor_recarga'];
                                       if(empty($valor_recarga)){
                                           $valor_recarga =0;    
                                       }
                                   ?>
                                   <center><div class="col-lg-6 col-lg-offset-4">
                                         <!-- small box -->
                                         <div class="small-box bg-yellow">
                                           <div class="inner">
                                             <p>Su saldo es</p><hr style="border-top: 1px solid white;">
                                             <h3><center>$ <?= $valor_recarga ?></center></h3>              
                                           </div>
                                           <div class="icon">
                                             <i class="ion ion-bag"></i>
                                           </div>
                                         </div>
                                   </div>   </center>
                        </div>
                </div>     
                 
                 <!--<h1 class="texto_tomate">Recargas</h1><hr></hr>-->
                 <hr></hr>                
                                  
                <div class="col-lg-6">
                    <h2 class="texto_tomate">Recarga por Transferencia</h2>
                    <h5>Para realizar una transferencia, haga click en <strong> RECARGA SALDO</strong></h5><br>
                              <div class="col-lg-6 col-xs-6">
                                  <!--<div class="small-box bg-yellow">-->
                                  <center>
                                        <?=
                                        Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>'. ' Recarga Saldo',
                                                ['//recarga-transferencia/create', 'user_id'=>$user_id],
                                                //['class'=>'small-box-footer btn-lg modalButton', 'title'=>'Haga click aquí para recargar Saldo', ]
                                                ['class'=>'btn btn-warning btn-lg modalButton', 'title'=>'Haga click aquí para recargar Saldo', ]
                                        );
                                        ?>
                                   </center>   
                                  <!--</div>-->
                                </div>  
                    

                </div>
                 <div class="col-lg-6">
                     <h2 class="texto_tomate">Recarga por Tarjeta de Crédito</h2>
                 </div> 
                 
                 
             </div>
         </div>
        </div>    
    
    
    
    

</div>    

<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-md',
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