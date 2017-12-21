<?php

namespace app\models;

use Yii;

class Factura extends \yii\db\ActiveRecord
{

    public function factura($nombre, $telefono, $cedula, $direccion, $email, $valor, $detalle_factura)
    {
    //Datos de Mobilvendor:
    $ruc_mv= '1792361575001';        
    $iva = ($valor *0.12);
    $total_mas_iva = $valor + $iva;
    
    //$cedularuc = $cedula.'001';
    $cedularuc = $cedula;
//    var_dump($cedularuc); die();
    
    //$fecha = date("Y-m-d H:i");
    $fecha = date("d/m/Y");
        $nuevafecha = strtotime ( '+10 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( "d/m/Y" , $nuevafecha );
    
    $fechaclave=date("dmY");
    $tipoComprobanteclave ='01';
    $rucclave ='1792361575001';
    $tipoAmbienteclave='2';
    $serieclave='001001';
    $nocomprobanteclave='000005691';
    $codNumericoclave = mt_rand(11111111, 99999999);
    $tipoEmisionclave = '1';  
    $claveAccesoparcial=$fechaclave.$tipoComprobanteclave.$rucclave.$tipoAmbienteclave.$serieclave.$nocomprobanteclave.$codNumericoclave.$tipoEmisionclave;
        $digito = $this->module11($claveAccesoparcial);
    $claveAcceso=$fechaclave.$tipoComprobanteclave.$rucclave.$tipoAmbienteclave.$serieclave.$nocomprobanteclave.$codNumericoclave.$tipoEmisionclave.$digito;
        
        //*********************************  ENVIAR DOCUMENTO ELECTRONICO, es posible enviar en una llamda hasta 50 documentos *******************/
$xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>        
<factura>
</factura>
        
XML;
$sxe = new \SimpleXMLElement($xmlstr);
$sxe->addAttribute('id', 'comprobante');
$sxe->addAttribute('version', '1.1.0');

$infoTributaria = $sxe->addChild('infoTributaria');
$infoTributaria->addChild('ambiente', 2);
$infoTributaria->addChild('tipoEmision', 1);
$infoTributaria->addChild('razonSocial', 'Mivsell Technology Company SA');
$infoTributaria->addChild('nombreComercial', 'Mivsell Tech');
$infoTributaria->addChild('ruc', $ruc_mv);
//$infoTributaria->addChild('claveAcceso', $claveAcceso);
$infoTributaria->addChild('claveAcceso');
$infoTributaria->addChild('codDoc', '01');
$infoTributaria->addChild('estab', '001');
$infoTributaria->addChild('ptoEmi', '001');
                                                                            $infoTributaria->addChild('secuencial', '000005712');
$infoTributaria->addChild('dirMatriz', 'WHYMPER E7-154 Y DIEGO DE ALMAGRO EDIFICIO GENEVA OF 102');

$infoFactura = $sxe->addChild('infoFactura');
$infoFactura->addChild('fechaEmision', $fecha);
$infoFactura->addChild('dirEstablecimiento', 'WHYMPER E7-154 Y DIEGO DE ALMAGRO EDIFICIO GENEVA OF 102');
$infoFactura->addChild('obligadoContabilidad', 'SI');
$infoFactura->addChild('tipoIdentificacionComprador', '04');
$infoFactura->addChild('razonSocialComprador', $nombre);
$infoFactura->addChild('identificacionComprador', $cedularuc);
$infoFactura->addChild('direccionComprador', $direccion);
$infoFactura->addChild('totalSinImpuestos', $valor);
$infoFactura->addChild('totalDescuento', 0.00);
    $infoFactura1 = $infoFactura->addChild('totalConImpuestos');
        $infoFactura2 = $infoFactura1->addChild('totalImpuesto');
        $infoFactura2->addChild('codigo', 2);
        $infoFactura2->addChild('codigoPorcentaje', 2);
        $infoFactura2->addChild('baseImponible', $valor);
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
$detalle->addChild('descripcion', $detalle_factura);
$detalle->addChild('cantidad', 1.0000);
$detalle->addChild('precioUnitario', $valor);
$detalle->addChild('descuento', 0.00);
$detalle->addChild('precioTotalSinImpuesto', $valor);
        $detallesAdicionales = $detalle->addChild('detallesAdicionales');
            $detAdicional = $detallesAdicionales->addChild('detAdicional');
                $detAdicional->addAttribute('nombre', 'Unidad');
                $detAdicional->addAttribute('valor', 'UNI');

        $impuestos = $detalle->addChild('impuestos');
            $impuesto = $impuestos->addChild('impuesto');
                $impuesto->addChild('codigo', 2);
                $impuesto->addChild('codigoPorcentaje', 2);
                //$impuesto->addChild('tarifa', $valor);
                $impuesto->addChild('tarifa', 12.00);
                $impuesto->addChild('baseImponible', $valor);
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

$sxe->asXML(Yii::$app->basePath.'\web\archivos\xml\preproduccion.xml');
 
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/
/*******************************************************************************************************************************************/

//Método que permite conectar a mobilvendor, autenticarse y enviar datos a WS de SRI  
        $sessionId = $this->login();
//	echo '<pre>$sessionId='.$sessionId.'</pre>';
        list($documents, $errors) = $this->sendDocuments($sessionId, array(file_get_contents(Yii::$app->basePath.'\web\archivos\xml\preproduccion.xml')));
//	echo '<pre>'.print_r($documents, 1).'</pre>';        
//	echo '<pre>'.print_r($errors, 1).'</pre>';
	sleep(4); // hay que esperar, pero depende de servidores de SRI - documento puede ser autorizado en 5 secundos, 10 minutos o 4 horas (no hay manera saber eso, cualqier tiempo puede salir)

	// VER ESTADO DE DOCUMENTOS ELECTRONICOS AUTORIZADOS O CON ERROR
	$processedDocuments = $this->getProcessedDocuments($sessionId);
	$processedDocumentIds = array();
                
        	foreach ($processedDocuments as $document) {
//                    print_r($document->last_error); 
                    if($document->status == 2){ // $document->status == 2 es error, campo $document->last_error tiene informacion sobre error
                        return array($document->status, $ruc_mv, $claveAcceso, $document->last_error);
                    }
                    else if(($document->status == 3)){ // $document->status == 3 es autorizado, campo $document->auth_code tiene codigo de autorizacion
                        return array($document->status, $ruc_mv, $claveAcceso);
                    }                    		
		$processedDocumentIds[] = $document->id;
	}

	if (!empty($processedDocumentIds)) {
		// para que no sale esos documentos procesados otro vez en proxima llamada de "getSriObjects " - hay que ocultar esos documentos con eso metodo
		$this->hideDocuments($sessionId, $processedDocumentIds);
	}
    //********************************* FIN ENVIAR DOCUMENTO ELECTRONICO, es posible enviar en una llamda hasta 50 documentos *******************/
}
        
/*****************************************************************************************************************************************/
/************************************************************* FUNCIONES DEL SRI**********************************************************/
/*****************************************************************************************************************************************/
function build($value, $node) {
//    $model = new Envio;
    if (is_array($value) == true) {
        foreach ($value as $key => $element) {
            if ($key == '@attributes') {
                foreach ($element as $n => $v) {
                    $node->addAttribute($n, $v);
                }
            } else {
                $newNode = $node->addChild($key);
                $this->build($element, $newNode);
            }
        }
    } else {
        $node->nodeValue = $value;
    }
}

    public function request($data) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');

		curl_setopt($ch, CURLOPT_URL, 'https://s08.mobilvendor.com/web-service');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language: es'));
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 1);

		$content = curl_exec($ch);
		$response = curl_getinfo($ch);

		curl_close($ch);

		if (!is_array($response) or $response['http_code'] != 200) {
			print_r($response);
			die('ERROR');
		}                

		$result = json_decode($content);        
                
		if ($result === null) throw new Exception('Respuesta no valida: '.$content);
		//if (isset($result->error)) throw new Exception('Error durante la respuesta: '.$result->error);
                if (isset($result->error)) print_r ($result->error);;

		return $result;
	}

	public function login() {
                $model = new Envio;
                
		$result = $this->request(array(
                    'action' => 'login', 
                    'login' => 'WEBSERVICE', 
                    'password' => 'webservice', 
                    'context' => 'pruebassri'));
		$sessionId = $result->session_id;
		return $sessionId;
	}

	public function sendDocuments($sessionId, $documents) {
		$result = $this->request(array('action' => 'putSriObjectsOffline', 'session_id' => $sessionId, 'records' => $documents));
		return array($result->records, $result->errors);
	}

	public function getProcessedDocuments($sessionId) {
		$result = $this->request(array('action' => 'getSriObjects', 'session_id' => $sessionId, 'filter' => array('process_status' => 1)));                
                // ===> print_r($result->last); //Descomentar esta linea y buscar last_error para verificar los inconvenientes
		return $result->records;
	}

	public function hideDocuments($sessionId, $ids) {
		$this->request(array('action' => 'updateSriObjects', 'session_id' => $sessionId, 'process_status' => 2, 'ids' => $ids));
	}
        
        //    Funcion para calculo de ultimo digito SRI
            public function module11($digits) {
            $arrayCoeficientes = array();
            $coef = 2;
            for ($i = 0; $i < strlen($digits); $i++) {
                $arrayCoeficientes[$i] = $coef;
                $coef = ($coef == 7) ? 2 : $coef + 1;
            }
            $arrayCoeficientes = array_reverse($arrayCoeficientes);
            $digitosIniciales = str_split($digits);
            $total = 0;
            foreach ($digitosIniciales as $key => $value) {
                $valorPosicion = ((int)$value * $arrayCoeficientes[$key]);
                $total = $total + $valorPosicion;
            }
            $residuo =  $total % 11;
            if ($residuo == 0) {
                $resultado = 0;
            } else {
                $resultado = 11 - $residuo;
                if ($resultado == 10) $resultado = 1;
            }
            return $resultado;
        }
}
