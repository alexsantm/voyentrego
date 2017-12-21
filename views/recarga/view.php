<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recarga */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recargas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//print_r($model->id); die();
if(empty($model->id) || !empty($model->id)){
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
                                               <p><h2>Su saldo es:</h2></p><hr style="border-top: 1px solid white;">
                                             <h3><center>$ <?= $valor_recarga ?></center></h3>              
                                           </div>
                                           <div class="icon">
                                             <i class="ion ion-bag"></i>
                                           </div>
                                         </div>
                                   </div>   </center>
                        </div>
                </div>     
            </div> 
        </div>      
                 
                 
                                                                 <hr></hr>                
                 

    <div class="row">
        <center><div class="col-lg-6 col-lg-offset-3">
                                   <?php
                                    $query = (new \yii\db\Query())
                                            ->select(['id', 'cast(valor as UNSIGNED) as valor', 'cast(valor_promo as UNSIGNED) as valor_promo'])
                                            ->from('planes_recarga')->all();
                                    ?>
                                    <div class="panel panel-warning">
                                        <div class="panel-heading" style="background-color: #ED6E23;"><center><h2 class="texto_tomate" style="color: white;">Planes de Recarga</h2></center> </div>
                                        <div class="panel-body">
                                            <?php
                                            if(!empty($query)){
                                                foreach ($query as $q) {
                                                    echo("<p><h3>Si recargas <strong>" . $q['valor'] . " USD</strong>, recibe <strong>" . $q['valor_promo'] . " USD</strong> extra</h3></p>");
                                                }
                                            }
                                            else{
                                                echo("<p><h3>No existen planes de Recarga</h3></p>");
                                            }
                                            ?>
                                        </div>    
                                    </div>
        </div></center>
   <!--     /*********************************************************************************************************************/-->
        <div class="col-lg-12">

               <div class="panel panel-warning">
               <div class="panel-heading" style="background-color: #ED6E23;"><center><h2 class="texto_tomate" style="color: white;">Recarga Saldo</h2></center> </div>
               <div class="panel-body">
                   <div class="col-lg-6">
                               <div class="panel panel-warning">
                                  <div class="panel-heading"> <h2 class="texto_tomate">Recarga por Transferencia</h2></div>
                                  <div class="panel-body">
                                          <strong>Importante:</strong><br>
                                          <li>No olvides adjuntar el documento de transferencia (foto o escaneado)</li>
                                          <li>Coloca el valor de la transferencia en el campo acorde con el documento</li><br><br>
                                          <div class="col-lg-6">
                                              <center>
                                                         <?=
                                                         Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>'. ' Recarga Saldo',
                                                                 ['//recarga-transferencia/create', 'user_id'=>$user_id],
                                                                 //['class'=>'small-box-footer btn-lg modalButton', 'title'=>'Haga click aquí para recargar Saldo', ]
                                                                 ['class'=>'btn btn-warning btn-lg modalButton', 'title'=>'Haga click aquí para recargar Saldo', ]
                                                         );
                                                         ?>
                                              </center>    
                                          </div>           
                                          <div class="col-lg-6">
                                              <center>
                                                  <?=
                                                     Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>'. ' Recarga por Plan',
                                                             ['//recarga-transferencia/createplan', 'user_id'=>$user_id],
                                                             //['class'=>'small-box-footer btn-lg modalButton', 'title'=>'Haga click aquí para recargar Saldo', ]
                                                             ['class'=>'btn btn-warning btn-lg modalButton', 'title'=>'Haga click aquí para recargar Saldo', ]
                                                     );
                                                  ?>
                                              </center>
                                          </div> 
                                  </div>
                              </div>
                    </div>   
                   <div class="col-lg-6">
                               <div class="panel panel-warning">
                                  <div class="panel-heading">  <h2 class="texto_tomate">Recarga por Tarjeta de Crédito</h2></div>
                                  <div class="panel-body">
                                                  <script src="https://js.stripe.com/v3/"></script>

                                                  <form action="/charge" method="post" id="payment-form">
                                                    <div class="form-row">
                                                      <label for="card-element">
                                                        Credit or debit card
                                                      </label>
                                                      <div id="card-element">
                                                        <!-- a Stripe Element will be inserted here. -->
                                                      </div>

                                                      <!-- Used to display form errors -->
                                                      <div id="card-errors" role="alert"></div>
                                                    </div>

                                                    <button>Submit Payment</button>
                                                  </form>                           
                                  </div>
                              </div> 
                    </div>   
               </div>         
        </div>
        </div>                                                                 
   </div>
</div>   
    
<?php
}
?>

<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-md',
		'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">Cancelar</a>',
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

<style>
    .content-wrapper{
        min-height: auto !important;
    }
    
    .StripeElement {
      background-color: white;
      padding: 8px 12px;
      border-radius: 4px;
      border: 1px solid transparent;
      box-shadow: 0 1px 3px 0 #e6ebf1;
      -webkit-transition: box-shadow 150ms ease;
      transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
      box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
      border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;
    }
</style>
    
    
    
<script>
                // Create a Stripe client
        var stripe = Stripe('pk_test_6pRNASCoBOKtIshFeQd4XMUh');

        // Create an instance of Elements
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
          base: {
            color: '#32325d',
            lineHeight: '24px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
          }
        };

        // Create an instance of the card Element
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
          var displayError = document.getElementById('card-errors');
          if (event.error) {
            displayError.textContent = event.error.message;
          } else {
            displayError.textContent = '';
          }
        });

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
          event.preventDefault();

          stripe.createToken(card).then(function(result) {
            if (result.error) {
              // Inform the user if there was an error
              var errorElement = document.getElementById('card-errors');
              errorElement.textContent = result.error.message;
            } else {
              // Send the token to your server
              stripeTokenHandler(result.token);
            }
          });
        });
</script>    
        
        
        