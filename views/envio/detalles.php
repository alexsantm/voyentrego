<?php
use yii\helpers\Html;
use yii\helpers\Url;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;
use kartik\mpdf\Pdf;

use yii\httpclient\Client;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Mensajeros Cercanos';
?>

<h2>Detalles de Factura</h2>
<div class="row">
    <?php
//    print_r(Yii::$app->request->get());
    $get = Yii::$app->request->get();
    
    $detalle_distancia_envio=$get['detalle_distancia_envio'];
    $total_km= $get['total_km'];    
    $valor_km= $get['valor_km'];    
    $nombre= $get['nombre'];  
    $direccion= $get['direccion'];  
    $telefono= $get['telefono'];  
    $cedula= $get['cedula'];  
    $email= $get['email']; 
    $valor_recarga= $get['valor_recarga']; 
    
    //Datos de Mobilvendor:
    $ruc_mv= 1792361575001;
    
    
    $iva = ($valor_km *0.12);
    $total_mas_iva = $total_km + $iva;
    
    //$fecha = date("Y-m-d H:i");
    $fecha = date("d/m/Y");
        $nuevafecha = strtotime ( '+10 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( "d/m/Y" , $nuevafecha );
    
    $fechaclave=date("dmY");
    $tipoComprobanteclave ='01';
    $rucclave ='1792361575001';
    $tipoAmbienteclave='2';
    $serieclave='001001 ';
    $nocomprobanteclave='000005691';
    $codNumericoclave ='12345678';
    $tipoEmisionclave = '1';
    $digitoVerificadorclave = '3';
    $claveAcceso=$fechaclave.$tipoComprobanteclave.$rucclave.$tipoAmbienteclave.$serieclave.$nocomprobanteclave.$codNumericoclave.$tipoEmisionclave.$digitoVerificadorclave;
    $claveAcceso1=$fechaclave.' '.$tipoComprobanteclave.' '.$rucclave.' '.$tipoAmbienteclave.' '.$serieclave.' '.$nocomprobanteclave.' '.$codNumericoclave.' '.$tipoEmisionclave.' '.$digitoVerificadorclave;

    $ejemplo_claveAcceso= '19102017 01 1792361575001 2 001001 000005874 38112698 1 1';
    
    print_r($ejemplo_claveAcceso);echo('<br>');
    print_r($claveAcceso1);echo('<br>');
    die();
    
//    echo('-----------');echo('<br>');
//    print_r($fechaclave);echo('<br>');
//    print_r($tipoComprobanteclave);echo('<br>');
//    print_r($rucclave);echo('<br>');
//    print_r($tipoAmbienteclave);echo('<br>');
//    print_r($serieclave);echo('<br>');
//    print_r($nocomprobanteclave);echo('<br>');
//    print_r($codNumericoclave);echo('<br>');
//    print_r($tipoEmisionclave);echo('<br>');
//    print_r($digitoVerificadorclave);echo('<br>');
//    print_r($claveAcceso);
//    die();
    
    
    
    echo('<br>'); echo('**************************'); echo('<br>');
//    echo ("Detalle Distancia Envio : "); echo($detalle_distancia_envio); echo('<br>');
//    echo ("total km: "); echo($total_km); echo('<br>');
//    echo ("valor km: "); echo($valor_km); echo('<br>');
//    echo ("Nombre "); echo($nombre); echo('<br>');
//    echo ("Direccion: "); echo($direccion); echo('<br>');
//    echo ("Telefono: "); echo($telefono); echo('<br>');
//    echo ("cedula: "); echo($cedula); echo('<br>');
//    echo ("Email: "); echo($email); echo('<br>');
//    echo ("Valor Recarga: "); echo($valor_recarga); echo('<br>');
    

//*********************************  ENVIAR DOCUMENTO ELECTRONICO, es posible enviar en una llamda hasta 50 documentos *******************/

/*************************************************************************************/
/*************************************************************************************/
/*************************************************************************************/

$xmlstr = <<<XML
<?xml version='1.0' standalone='yes'?>
<factura>
</factura>
        
XML;
$sxe = new SimpleXMLElement($xmlstr);
$sxe->addAttribute('id', 'comprobante');
$sxe->addAttribute('version', '1.1.0');

$infoTributaria = $sxe->addChild('infoTributaria');
$infoTributaria->addChild('ambiente', 2);
$infoTributaria->addChild('tipoEmision', 1);
$infoTributaria->addChild('razonSocial', 'Mivsell Technology Company SA');
$infoTributaria->addChild('ruc', $ruc_mv);
$infoTributaria->addChild('nombreComercial', 'Mivsell Tech');

$infoTributaria->addChild('claveAcceso', $claveAcceso);
$infoTributaria->addChild('codDoc', '01');
$infoTributaria->addChild('estab', '001');
$infoTributaria->addChild('ptoEmi', '001');
$infoTributaria->addChild('secuencial', '000005691');
$infoTributaria->addChild('dirMatriz', 'WHYMPER E7-154 Y DIEGO DE ALMAGRO EDIFICIO GENEVA OF 102');
//$pelicula->addChild('argumento', 'Todo sobre las personas que hacen que funcione.');

$infoFactura = $sxe->addChild('infoFactura');
$infoFactura->addChild('fechaEmision', $fecha);
$infoFactura->addChild('dirEstablecimiento', 'WHYMPER E7-154 Y DIEGO DE ALMAGRO EDIFICIO GENEVA OF 102');
$infoFactura->addChild('obligadoContabilidad', 'SI');
$infoFactura->addChild('tipoIdentificacionComprador', '04');
$infoFactura->addChild('razonSocialComprador', $nombre);
$infoFactura->addChild('identificacionComprador', $cedula);
$infoFactura->addChild('direccionComprador', $direccion);
$infoFactura->addChild('totalSinImpuestos', $valor_km);
$infoFactura->addChild('totalDescuento', 0.00);
    $infoFactura1 = $infoFactura->addChild('totalConImpuestos');
        $infoFactura2 = $infoFactura1->addChild('totalImpuesto');
        $infoFactura2->addChild('codigo', 2);
        $infoFactura2->addChild('codigoPorcentaje', 2);
        $infoFactura2->addChild('baseImponible', $valor_km);
        $infoFactura2->addChild('valor', $iva);
$infoFactura->addChild('propina', 0.00);
$infoFactura->addChild('importeTotal', $total_mas_iva);
$infoFactura->addChild('moneda', 'DOLAR');
    $infoFactura1 = $infoFactura->addChild('pagos');
        $infoFactura2 = $infoFactura1->addChild('pago');
        $infoFactura2->addChild('formaPago', '01');
        $infoFactura2->addChild('total', $total_mas_iva);
        $infoFactura2->addChild('plazo', 10);
        $infoFactura2->addChild('unidadTiempo', 'dias');
               
$detalles = $sxe->addChild('detalles');
$detalle = $detalles->addChild('detalle');
$detalle->addChild('codigoPrincipal', 'MOBILVENDOR2_APP_LICENSE');
$detalle->addChild('codigoAuxiliar', 0);
$detalle->addChild('descripcion', $detalle_distancia_envio);
$detalle->addChild('cantidad', 1.0000);
$detalle->addChild('precioUnitario', $valor_km);
$detalle->addChild('descuento', 0.00);
$detalle->addChild('precioTotalSinImpuesto', $valor_km);
        $detallesAdicionales = $detalle->addChild('detallesAdicionales');
            $detAdicional = $detallesAdicionales->addChild('detAdicional');
                $detAdicional->addAttribute('nombre', 'Unidad');
                $detAdicional->addAttribute('valor', 'UNI');

        $impuestos = $detalle->addChild('impuestos');
            $impuesto = $impuestos->addChild('impuesto');
                $impuesto->addChild('codigo', 2);
                $impuesto->addChild('codigoPorcentaje', 2);
                $impuesto->addChild('tarifa', $valor_km);
                $impuesto->addChild('baseImponible', $valor_km);
                $impuesto->addChild('valor', $iva);
                
$infoAdicional = $sxe->addChild('infoAdicional');     
    $infoAdicional1 = $infoAdicional->addChild('campoAdicional', '001-001-000005691');
                $infoAdicional1->addAttribute('nombre', 'Factura');
    $infoAdicional1 = $infoAdicional->addChild('campoAdicional', 'SERVICIOS DE MIVSELL');
                $infoAdicional1->addAttribute('nombre', 'Comentario');
    $infoAdicional1 = $infoAdicional->addChild('campoAdicional', $nombre);
                $infoAdicional1->addAttribute('nombre', 'Cliente');
    $infoAdicional1 = $infoAdicional->addChild('campoAdicional', $direccion);
                $infoAdicional1->addAttribute('nombre', 'Direccion');
    $infoAdicional1 = $infoAdicional->addChild('campoAdicional', $telefono);
                $infoAdicional1->addAttribute('nombre', 'Telefono');
    $infoAdicional1 = $infoAdicional->addChild('campoAdicional', $email);
                $infoAdicional1->addAttribute('nombre', 'Email');
    $infoAdicional1 = $infoAdicional->addChild('campoAdicional', '10 dias');
                $infoAdicional1->addAttribute('nombre', 'Termino de Pago');            
    $infoAdicional1 = $infoAdicional->addChild('campoAdicional', $nuevafecha);
                $infoAdicional1->addAttribute('nombre', 'Fecha de Vencimiento');            


print_r($sxe->asXML());
$sxe->asXML(Yii::$app->basePath.'\web\archivos\xml\ejemplo5.xml');
 
/*************************************************************************************/
/*************************************************************************************/
/*************************************************************************************/

//Método que permite conectar a mobilvendor, autenticarse y enviar datos a WS de SRI  

        $sessionId = $model->login();
//	echo '<pre>$sessionId='.$sessionId.'</pre>';
            
	//list($documents, $errors) = $model->sendDocuments($sessionId, array(file_get_contents(__DIR__.'/FA001-001-000005659.xml')));
//        list($documents, $errors) = $model->sendDocuments($sessionId, array(file_get_contents(__DIR__.'../FA001-001-000005659.xml')));


        //list($documents, $errors) = $model->sendDocuments($sessionId, array(file_get_contents(Yii::$app->basePath.'\web\archivos\xml\FA001-001-000005659.xml')));
        list($documents, $errors) = $model->sendDocuments($sessionId, array(file_get_contents(Yii::$app->basePath.'\web\archivos\xml\ejemplo5.xml')));

//	echo '<pre>'.print_r($documents, 1).'</pre>';
//	echo '<pre>'.print_r($errors, 1).'</pre>';
	sleep(5); // hay que esperar, pero depende de servidores de SRI - documento puede ser autorizado en 5 secundos, 10 minutos o 4 horas (no hay manera saber eso, cualqier tiempo puede salir)

	// VER ESTADO DE DOCUMENTOS ELECTRONICOS AUTORIZADOS O CON ERROR
	$processedDocuments = $model->getProcessedDocuments($sessionId);
	$processedDocumentIds = array();

	foreach ($processedDocuments as $document) {
		// $document->status == 2 es error, campo $document->last_error tiene informacion sobre error
		// $document->status == 3 es autorizado, campo $document->auth_code tiene codigo de autorizacion
                
            if($document->status == 2){
//                print_r("status 2"); die();
                echo '<div class="alert alert-danger"><pre>ESTADO='.$document->status.', AUTH='.$document->auth_code.'</pre></div>';
            }
            else if(($document->status == 3) || empty($document->status) ){
//                print_r("status 3"); die();
                echo '<div class="alert alert-success"><pre>ESTADO='.$document->status.', AUTH='.$document->auth_code.'</pre></div>';
            }
            else{
                print_r("otro estado"); die();
            }
            
		echo '<pre>'.print_r($document->last_error, 1).'</pre>';
		echo '<pre>'.print_r($document, 1).'</pre>';
		echo '<hr/>';

		$processedDocumentIds[] = $document->id;
	}

	if (!empty($processedDocumentIds)) {
		// para que no sale esos documentos procesados otro vez en proxima llamada de "getSriObjects " - hay que ocultar esos documentos con eso metodo
		$model->hideDocuments($sessionId, $processedDocumentIds);
	}
    //********************************* FIN ENVIAR DOCUMENTO ELECTRONICO, es posible enviar en una llamda hasta 50 documentos *******************/
?>
</div>

<h2>Mensajeros Cercanos</h2>

<?php
//echo Html::a('<i class="glyphicon glyphicon-barcode"></i> Generar Factura', ['/envio/factura'], [
//    'class'=>'btn btn-danger', 
//    'target'=>'_blank', 
//    'data-toggle'=>'tooltip', 
//    'title'=>'Descargue su Factura'
//]);
?>
<?= Html::a( '<i class="glyphicon glyphicon-barcode"></i> Descargar Factura',
                                        ['/envio/factura', 
                                            //Datos para Factura:
                                            'detalle_distancia_envio'=>$detalle_distancia_envio,
                                            'total_km'=>$total_km,
                                            'valor_km'=>$valor_km, 
                                            'nombre'=>$nombre, 
                                            'direccion'=>$direccion, 
                                            'telefono'=>$telefono, 
                                            'cedula'=>$cedula, 
                                            'email'=>$email, 
                                            'valor_recarga'=>$valor_recarga,
                                            
                                            'detalle_distancia_envio'=>$detalle_distancia_envio,
                                            
                                            'ruc_mv'=>$ruc_mv,
                                            'clave_acceso'=>$claveAcceso,
                                            'autorizacion'=>$document->auth_code,
                                        ],    
                                            [
                                                'class'=>'btn btn-danger btn-lg', 
                                                'target'=>'_blank', 
                                                'data-toggle'=>'tooltip', 
                                                'title'=>'Descargue su Factura'
                                            ]
                                        );
?>

<?php
$coord_centro = new LatLng(['lat' => $latitud_origen, 'lng' => $longitud_origen]);

$map = new Map([
    'center' => $coord_centro,
    'zoom' => 13,
    'width' => '100%'
]);

$marker_centro = new Marker([
    'position' => $coord_centro, 
    'title' => 'Origen',
    'animation' => 'google.maps.Animation.DROP',
    'icon' => \yii\helpers\Url::base().'/images/markers/origen.png',
    ]);

$marker_centro->attachInfoWindow(new InfoWindow(['content' => 'Origen']));


$circle = new \dosamigos\google\maps\overlays\Circle([
    'center' => $coord_centro, 
    'radius' => $radio,  //En metros desde la tabla OPCIONES
    'strokeColor' => '#2196F3', 
    'strokeWeight' => 1, 
    'fillOpacity' => 0.08
]);
$marker_centro->attachInfoWindow(new InfoWindow(
        ['content' => "<h4><strong>Origen</strong></h4>"
        ]));

        
$map->addOverlay($marker_centro);


foreach ($mensajeros as $f) {
    $coord = new LatLng(['lat' => $f['latitud'], 'lng' => $f['longitud']]);
    $aux = \app\models\Profile::find()->where(['user_id'=>$f['user_id']])->asArray()->one();
    $full_name = $aux['full_name'];
    $marker = new Marker([
                'position' => $coord,
//                'title' => 'Mensajero: '.$f['user_id'],
                'title' => $full_name,
                'animation' => 'google.maps.Animation.DROP',
                'visible'=>'true'
            ]);

if(empty($full_name)){
    $marker->attachInfoWindow(new InfoWindow(['content' => "Sin nombre registrado" ])); 
}
else{
    $marker->attachInfoWindow(new InfoWindow(['content' => $full_name ]));  
}
    
     $map->addOverlay($marker);     
}    

$map->addOverlay($circle);
echo $map->display();


?>


<?php
//********************************************Calculo de distancias entre el origen y los mensajeros***************************************/
        $model = new \app\models\Envio;
        $radio_en_km = $radio /1000;
        $id_usuario = Yii::$app->user->identity['id'];
        $favorito = \app\models\Favoritos::find()->select('mensajero_id')->asArray()->all();
               
        foreach($favorito as $fav){
            $favorito_id = $fav['mensajero_id'];                
                foreach ($mensajeros as $f) {
                    $latitud_destino = $f['latitud'];
                    $longitud_destino = $f['longitud'];   
                    $mensajero_id =$f['user_id'];                    

                    $valor_distancia = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_destino, $longitud_destino);
//                    $valor_distancia1[] = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_destino, $longitud_destino);

                    if(($valor_distancia < $radio_en_km)){
                        if($mensajero_id == $favorito_id){
//                            echo('Mensajero favorito: '); print_r($mensajero_id); echo('<br>');
                            $mensajero = $model->detallesMensajero($mensajero_id);  
                            echo($mensajero);
                            return;
                        }
                        if($mensajero_id != $favorito_id){
//                            echo('Mensajero: '); print_r($mensajero_id); echo('<br>');
                            $mensajero = $model->detallesMensajero($mensajero_id);  
                            echo($mensajero);
                            return;
                        }
                    }
                    else{   
                        //Guardo los datos en la tabla temporal
                        $connection = Yii::$app->getDb();
                                     $command = $connection->createCommand('                                   
                                     INSERT INTO distancia_temp(mensajero_id, km)
                                     values ('.$mensajero_id.', '.$valor_distancia.')
                                     ');                   
                                     $resultado = $command->execute(); 
                          //Extraigo el valor minimo de la distancia           
                         $valor_minimo = \app\models\DistanciaTemp::find()->select(['mensajero_id'])->min('km');
                         
                         //busco el id del mensajero
                         $id_mjs = \app\models\DistanciaTemp::find()->select('mensajero_id')->where(['km'=>$valor_minimo])->asArray()->one();
                         $id_mensajero = $id_mjs['mensajero_id'];
                                     
                         $mensajero = $model->detallesMensajero($id_mensajero);  
                    }
                }
       }        
       if($mensajero){
                             echo($mensajero);
                             //Elimino los datos de la tabla temporal                                                 
                                     $x = Yii::$app->db->createCommand("
                                        DELETE FROM distancia_temp 
                                    ")->execute();
                             return;        
                         }
?>



<style>
    #gmap0-map-canvas{
        height: 768px !important;
    }

</style>


