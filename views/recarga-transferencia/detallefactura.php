<?php
use kartik\mpdf\Pdf;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<title>Facturación</title>
<?php
$this->title = "Facturación";

/*Las siguientes variables fueron pasadas desde RecargaTransferenciaController:
 * $nombre
 * $direccion
 * $telefono
 * $cedula
 * $email
 * $valor
 */
//*********************************  LLAMA FUNCION FACTURA *******************/
$user_id = Yii::$app->user->identity['id'];
$detalles_factura = "Recarga de Saldo";
$model= new app\models\Factura();
  $factura = $model->factura($nombre, $telefono, $cedula, $direccion, $email, $valor, $detalles_factura);
  $estado=$factura[0];
  $ruc_mv=$factura[1];
  $claveAcceso=$factura[2]; 
  if(!empty($factura[3])){
      $errorValidacion=$factura[3]; 
  }

if($estado ==2){
   echo '<div class="alert alert-danger"><pre>Error='.$errorValidacion.'</pre></div>';
}
else if($estado ==3){
   //echo '<div class="alert alert-success"><pre>ESTADO='.$estado.', AUTH='.$document->auth_code.'</pre></div>';
   echo '<div class="alert alert-success"><pre>ESTADO='.$estado.'</pre>Factura Aprobada</div>';
}
//*********************************  FIN LLAMA FUNCION FACTURA *******************/ 
?>
    <div class="row">        
    <div class="col-lg-6  col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading"> <center><h2><strong>Facturación</strong></h2></center></div>
                <div class="panel-body">   
                    <p>Instrucciones para descarga de Factura</p>
                    <li>Haga click en "Descargar Factura"</li>
                    <li>En nombre de Usuario y Contraseña ingrese su RUC.</li>
                    <li>Una vez ingresado se recomienda cambiar la contraseña</li>
                    <li>Puede descargar sus Facturas en la sección "Facturas"</li>
                    <li>Una vez que su valor sea validado, se procederá a actualizar su saldo.</li><br>
                    <div class="row">
                            <center>   
                                <div class="col-lg-6">
                            <p>             
                            <?php
//                            Html::a( '<i class="glyphicon glyphicon-barcode "></i> Descargar Factura',
//                                  ['/recarga-transferencia/factura', 
//                                      //Datos para Factura:
//                                      'nombre'=>$nombre, 
//                                      'direccion'=>$direccion, 
//                                      'telefono'=>$telefono, 
//                                      'cedula'=>$cedula, 
//                                      'email'=>$email, 
//                                      'valor'=>$valor,
//                                      'detalle_factura'=>$detalles_factura,
//                                      'clave_acceso'=>$claveAcceso,
//                                      'ruc_mv'=>$ruc_mv,
////                                                              'autorizacion'=>$document->auth_code,
//                                  ],    
//                                      [
//                                          'class'=>'btn btn-danger btn-lg', 
//                                          'target'=>'_blank', 
//                                          'data-toggle'=>'tooltip', 
//                                          'title'=>'Descargue su Factura'
//                                      ]
//                                  );
                            ?>
                            <a href='https://s08.mobilvendor.com/sri' class="btn btn-danger btn-lg" title='Descargue su Factura' target='_blank' alt='Descargue su Factura'><i class="glyphicon glyphicon-barcode "></i> Descargue su Factura</a>    
                            </p>
                            </div>    
                                
                                <div class="col-lg-6">
                            <p>  
                            <?= Html::a( '<i class="glyphicon glyphicon-backward "></i>Volver a Recargas',
//                                ['/recarga/view'],   
                                ['/recarga/view','id'=>$user_id],    
                                [
                                        'class'=>'btn btn-warning btn-lg', 
                                        'target'=>'_blank', 
                                        'data-toggle'=>'tooltip', 
                                        'title'=>'Descargue su Factura'
                                ]
                                );
                            ?>
                            </p>
                            </div>    
                            </center>                    
                    </div>    
                </div>
            </div>  
    </div>                    
    </div> 

