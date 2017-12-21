<?php
use yii\helpers\Html;
//print_r (Yii::$app->request->get()); die();
//Captura de valores
$nombre = Yii::$app->request->get('nombre'); 
$direccion = Yii::$app->request->get('direccion'); 
$telefono = Yii::$app->request->get('telefono'); 
$cedula = Yii::$app->request->get('cedula'); 
$email = Yii::$app->request->get('email'); 
$valor = Yii::$app->request->get('valor'); 
$detalle_factura = Yii::$app->request->get('detalle_factura'); 
$cod_autorizacion = Yii::$app->request->get('autorizacion'); 

$ruc_mv = Yii::$app->request->get('ruc_mv'); 
$clave_acceso = Yii::$app->request->get('clave_acceso'); 

//Valores adicionales para FActura
$fecha = date("Y-m-d H:i"); 
$fechaplazo = strtotime ( '+10 day' , strtotime ( $fecha ) ) ;
        $fechaplazo = date ( "d/m/Y" , $fechaplazo );
$iva = $valor * 0.12;
$total = $valor + $iva;
?>

<div class="logo">    
    <?= Html::img('@web/images/logos/logo_mobilvendor.png', ['width' => '40%', 'height' => '15%']); ?>
</div> 

<table>
    <tr>
        <td  style="border: solid 1px grey;">
            <div class="infoempresa">
                <p>Mivsell Technology Company SA</p>
                <p>Dirección Matriz: <br>WHYMPER E7-154 Y DIEGO DE ALMAGRO EDIFICIO GENEVA OF 102</p>
                <p>Dirección Sucursal: <br>WHYMPER E7-154 Y DIEGO DE ALMAGRO EDIFICIO GENEVA OF 102</p>
                <p>Obligado a llevar Contabilidad: SI</p>
            </div>
        </td>
        
        <td  style="border: solid 1px grey;">
             <div class="infoempresa">
                <p>RUC: <?= $ruc_mv ?></p>
                <p>FACTURA: 00056</p>
                <p>NUMERO DE AUTORIZACION: <br><?= $clave_acceso ?></p>
                <p>FECHA DE AUTORIZACION: <?= $fecha ?></p>
                <p>AMBIENTE: Producción</p>
                <p>EMISION: Normal</p>
            </div>
        </td>
    </tr>
    
</table>


<!--Codigo de Barras-->
<div class="row">
    <center>
        <div style="width: 75%; margin: 0 auto; height: auto; text-align: center;">
        <?= Html::img('@web/images/logos/codigo_barras.png', ['width' => '60%', 'height' => '20%']); ?>
        <p><?= $clave_acceso ?></p>    
        </div>                
    </center>
</div>
    

<!--Detalle de Factura-->
<table style="border: solid 1px grey;">
    <tr>
        <th style="width: 150px; border: solid 1px grey; text-align: center;">Código Principal</th>
        <th style="width: 75px; border: solid 1px grey; text-align: center;">Código Auxiliar</th>
        <th style="width: 75px; border: solid 1px grey; text-align: center;">Cantidad</th>
        <th style="width: 200px; border: solid 1px grey; text-align: center;">Descripción </th>
        <th style="width: 75px; border: solid 1px grey; text-align: center;">Unidad </th>
        <th style="width: 75px; border: solid 1px grey; text-align: center;">Precio Unitario </th>
        <th style="width: 75px; border: solid 1px grey; text-align: center;">Descuento </th>
        <th style="width: 75px; border: solid 1px grey; text-align: center;">Precio Total </th>
    </tr>
    
    <tr>
        <td style="width: 150px; border: solid 1px grey; text-align: center;">SERV_VOYENTREGO</td>
        <td style="width: 75px; border: solid 1px grey; text-align: center;">0</td>
        <td style="width: 75px; border: solid 1px grey; text-align: center;">1</td>
        <td style="width: 200px; border: solid 1px grey; text-align: center;"><?= $detalle_factura ?></td>        
        <td style="width: 75px; border: solid 1px grey; text-align: center; ">UNI</td>
        <td style="width: 75px; border: solid 1px grey; text-align: center;"><?= $valor?></td>
        <td style="width: 75px; border: solid 1px grey;text-align: center; ">0</td>
        <td style="width: 75px; border: solid 1px grey;text-align: center; "><?= $valor ?></td>
    </tr>
 </table>

<br><br>
<div class="container">
    <div class="row" style="width: 50%; float:left">
        <div style="width: 100%;"><h4>Información Adicional</h4></div>
        <div style="width: 45%; float:left">Factura:</div><div>00056</div>
        <div style="width: 45%; float:left">Comentario:</div><div>Servicio de Mensajería VoyEntrego</div>
        <div style="width: 45%; float:left">Cliente: </div><div><?= $nombre ?></div>
        <div style="width: 45%; float:left">Dirección: </div><div><?= $direccion ?></div>
        <div style="width: 45%; float:left">Teléfono: </div><div><?= $telefono ?></div>
        <div style="width: 45%; float:left">Email: </div><div><?= $email ?></div>
        <div style="width: 45%; float:left">Términos de Pago: </div><div>30 días</div>
        <div style="width: 45%; float:left">Fecha de Vencimiento: </div><div><?= $fechaplazo ?></div>
    </div>
        
    <div class="row" style="width: 50%;  float:right">
           <div style="width: 70%; text-align: right; float:left">SUBTOTAL 12%:</div><div style="text-align: right"> <?= $valor?></div>
           <div style="width: 70%; text-align: right; float:left">SUBTOTAL 0%:</div><div style="text-align: right"> 0</div>
           <div style="width: 70%; text-align: right; float:left">SUBTOTAL NO SUJETO DE IVA:</div><div style="text-align: right"> 0</div>
           <div style="width: 70%; text-align: right; float:left">SUBTOTAL SIN IMPUESTOS:</div><div style="text-align: right"> <?= $valor ?></div>
           <div style="width: 70%; text-align: right; float:left">DESCUENTO:</div><div style="text-align: right"> 0</div>
           <div style="width: 70%; text-align: right; float:left">IVA 12%:</div><div style="text-align: right"><?= $iva; ?></div>
           <div style="width: 70%; text-align: right; float:left">IRBPNR: </div><div style="text-align: right">0</div>
           <div style="width: 70%; text-align: right; float:left">PROPINA: </div><div style="text-align: right">0</div>
           <div style="width: 70%; text-align: right; float:left"><strong>VALOR TOTAL:</strong></div><div style="text-align: right"><strong><?= $total; ?></strong></div>        
    </div>
</div>

<br>
<table>    
    <tr>  
        <td style="width: 150px; border: solid 1px grey;">Forma de Pago</td>
        <td style="width: 50px; border: solid 1px grey;">Valor</td>
        <td style="width: 50px; border: solid 1px grey;">Plazo</td>
        <td style="width: 50px; border: solid 1px grey;">Tiempo</td>
    </tr>    
    <tr>
        <td style="width: 150px; border: solid 1px grey;">SIN UTILIZACION DEL SISTEMA</td>
        <td style="width: 50px; border: solid 1px grey;"><?= $valor ?></td>
        <td style="width: 50px; border: solid 1px grey;">30</td>
        <td style="width: 50px; border: solid 1px grey;">días</td>
    </tr>       
</table>



