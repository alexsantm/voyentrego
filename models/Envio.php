<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "envio".
 *
 * @property integer $id
 * @property integer $ciudad_id
 * @property integer $user_id
 * @property string $remitente
 * @property string $direccion_origen
 * @property string $latitud
 * @property string $longitud
 * @property string $celular
 * @property string $fecha_registro
 * @property string $fecha_fin_envio
 * @property string $total_km
 * @property string $valor_total
 * @property string $observacion
 * @property integer $estado_envio_id
 * @property integer $tipo_envio_id
 * @property integer $dimensiones_id
 * @property integer $mensajero_id
 *
 * @property Destino[] $destinos
 * @property DetalleFactura[] $detalleFacturas
 * @property Ciudad $ciudad
 * @property Dimensiones $dimensiones
 * @property EstadoEnvio $estadoEnvio
 * @property TipoEnvio $tipoEnvio
 * @property User $user
 * @property User $mensajero
 */
class Envio extends \yii\db\ActiveRecord
{
        public $address;
        public $longitude;
        public $latitude;
        
        public $favorito;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'envio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['ciudad_id', 'user_id', 'remitente', 'direccion_origen', 'tipo_envio_id', 'dimensiones_id', 'fecha_registro'], 'required'],
            [['ciudad_id', 'user_id', 'remitente', 'direccion_origen', 'tipo_envio_id', 'dimensiones_id'], 'required'],
//            ['address', 'required',  'message'=>'Por favor digite una dirección para ser ubicado en el Mapa'],
            [['ciudad_id', 'user_id', 'estado_envio_id', 'tipo_envio_id', 'dimensiones_id', 'mensajero_id'], 'integer'],
            //[['latitud', 'longitud', 'total_km', 'valor_total'], 'number'],
            [['total_km', 'valor_total'], 'number'],
            
            [['latitude', 'longitude', 'latitud', 'longitud', 'fecha_registro', 'address'], 'safe'],
            
            [['remitente', 'direccion_origen', 'fecha_registro', 'fecha_fin_envio'], 'string', 'max' => 45],
            
//            [['fecha_registro'], 'compare', 'compareAttribute'=> date("Y-m-d"), 'operator'=>'>=', 'message'=>'La Fecha de Registro debe ser mayor al dia actual'],
            ['fecha_registro','validateDates'],
            
            [['celular'], 'string', 'max' => 10],
            [['observacion'], 'string', 'max' => 300],
            [['ciudad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['ciudad_id' => 'id']],
            [['dimensiones_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dimensiones::className(), 'targetAttribute' => ['dimensiones_id' => 'id']],
            [['estado_envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoEnvio::className(), 'targetAttribute' => ['estado_envio_id' => 'id']],
            [['tipo_envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoEnvio::className(), 'targetAttribute' => ['tipo_envio_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['mensajero_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['mensajero_id' => 'id']],
        ];
    }


public function validateDates(){
    $fecha_actual = date("Y-m-d");
     if(strtotime($this->fecha_registro) <= strtotime($fecha_actual)){
        $this->addError('Fecha Registro','La Fecha Registro debe ser mayor o igual  a la Fecha Actual');
    }
}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ciudad_id' => Yii::t('app', 'Ciudad ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'remitente' => Yii::t('app', 'Remitente'),
            'direccion_origen' => Yii::t('app', 'Direccion Origen'),
            'latitud' => Yii::t('app', 'Latitud'),
            'longitud' => Yii::t('app', 'Longitud'),
            'celular' => Yii::t('app', 'Celular'),
            'fecha_registro' => Yii::t('app', 'Fecha Registro'),
            'fecha_fin_envio' => Yii::t('app', 'Fecha Fin Envio'),
            'total_km' => Yii::t('app', 'Total Km'),
            'valor_total' => Yii::t('app', 'Valor Total'),
            'observacion' => Yii::t('app', 'Observacion'),
            'estado_envio_id' => Yii::t('app', 'Estado Envio ID'),
            'tipo_envio_id' => Yii::t('app', 'Tipo Envio ID'),
            'dimensiones_id' => Yii::t('app', 'Dimensiones ID'),
            'mensajero_id' => Yii::t('app', 'Mensajero ID'),
            'address' => Yii::t('app', 'Direccion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinos()
    {
        return $this->hasMany(Destino::className(), ['envio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleFacturas()
    {
        return $this->hasMany(DetalleFactura::className(), ['envio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['id' => 'ciudad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDimensiones()
    {
        return $this->hasOne(Dimensiones::className(), ['id' => 'dimensiones_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoEnvio()
    {
        return $this->hasOne(EstadoEnvio::className(), ['id' => 'estado_envio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoEnvio()
    {
        return $this->hasOne(TipoEnvio::className(), ['id' => 'tipo_envio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajero()
    {
        return $this->hasOne(User::className(), ['id' => 'mensajero_id']);
    }
    
    
                    /**********************************************************************************************/
                    /**********************************************************************************************/
                    /**********************************************************************************************/
    public function calculo_distancia($lat_orig, $long_orig, $lat_dest, $long_dest){
        $latitud_origen = $lat_orig;
        $longitud_origen = $long_orig;
        $latitud_destino = $lat_dest;
        $longitud_destino = $long_dest;
        
        $latlng_origin        = [$latitud_origen,$longitud_origen];
        $latlng_destination   = [$latitud_destino,$longitud_destino];
        $unit                 = 'km'; // 'miles' or 'km'
        $distancia        = \Yii::$app->googleApi->getDistance($latlng_origin, $latlng_destination, $unit);
        return $distancia;
    }
        
    public function calculo_valores($tot){
        $total = $tot;
               //Tabla parametrizacion
        $valores = Valores::find()         //extraigo tabla de Premios Por Transferencia
                    ->asArray()->all(); 

          foreach ($valores as $val) {        //Itero la tabla parametrizacion  premios y relaciono el porcentaje calculado
                        $connection = Yii::$app->getDb();
                        $command = $connection->createCommand('                                   
                            select valor from valores where '. $total .' 
                            between km_inicio and km_fin');
                        $resul = $command->queryAll();
                        $contador = count($resul);

                        if($contador ==0){            
                            $valor_km = 'No Existe Valor'; 
                            return $valor_km;
                        }
                        else{
                            foreach ($resul as $re) {
                                $valor_km = $re['valor'];                                
                            } 
                            return $valor_km;
                        }
         }  
    }
    
    
    
    
    public function exact_distance($latitud1, $longitud1, $latitud2, $longitud2)
    {
        $lat1 = $latitud1;
        $lat2 = $latitud2;
        $lon1 = $longitud1;
        $lon2 = $longitud2;
        
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(
                deg2rad($theta)
            );
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        
        $distance = $miles * 1.609344;
        return $distance;
    }
    
    
    /**********************************************************************************************/
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }
    
    
        public function detallesMensajero($id)
    {
        $mensajero_id = $id;
        $det = \app\models\Profile::find()->where(['user_id'=>$mensajero_id])->asArray()->one();
        $nombre = $det['full_name'];
        $celular = $det['telefono'];
        
        if(empty($foto)){
            $foto = Yii::$app->request->BaseUrl.'/images/fotos/default.jpg';
        }else{
//            $foto = $det['foto'];
            $foto = Yii::$app->request->BaseUrl.'/images/fotos/'.$foto;
        }
        $htmlMsg = "
                <center><br><div class='row' style='width:600px; background-color: white;'>
                <div class='seccion_tomate_detalles_mensajero'><h3>Mensajero Encontrado</h3></div>
                    <div class='col-lg-5'>
                        <p><h3>Nombre:</h3> ".$nombre.".</p>
                        <p><h3>Telefono:</h3> ".$celular.".</p>
                    </div>
                    <div class='col-lg-7' style='padding:10px 10px;'>
                            <img src=".$foto." class='rounded sombra' alt='Responsive image' style='width:175px; height: 175px;'>
                    </div><br>
                </div></center>
                ";
        return $htmlMsg;
    }   
    
    
    
//    public function actionFactura() {
//        print_r("llegue"); die();
////    $pdf = new Pdf([
////        'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
////        'content' => $this->renderPartial('index'),
////        'options' => [
////            'title' => 'Privacy Policy - Krajee.com',
////            'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
////        ],
////        'methods' => [
////            'SetHeader' => ['Generated By: Krajee Pdf Component||Generated On: ' . date("r")],
////            'SetFooter' => ['|Page {PAGENO}|'],
////        ]
////    ]);
////    return $pdf->render();
//}
    
    /********************************************** FUNCIONES PARA FACTURA SRI***********************************************/
//    public function array_to_xml( $data, &$xml_data ) {
//         $model = new Envio;
//    foreach( $data as $key => $value ) {
//        if( is_numeric($key) ){
//            $key = 'item'.$key; //dealing with <0/>..<n/> issues
//        }
//        if( is_array($value) ) {
//            $subnode = $xml_data->addChild($key);
//            $model->array_to_xml($value, $subnode);
//        } else {
//            $xml_data->addChild("$key",htmlspecialchars("$value"));
//        }
//     }
//}


//function array_to_xml(\SimpleXMLElement $object, array $data)
//{   
//    $model = new Envio;
//    foreach ($data as $key => $value) {
//        if (is_array($value)) {
//            $new_object = $object->addChild($key);
//            $model->array_to_xml($new_object, $value);
//        } 
//        else if ($key == '@attributes') {
//                foreach ($value as $n => $v) {
//                    $object->addAttribute($n, $v);
//                }
//            } 
//        
//        else {
//            // if the key is an integer, it needs text with it to actually work.
//            if ($key == (int) $key) {
//                $key = "key_$key";
//            }
//
//            $object->addChild($key, $value);
//        }   
//    }   
//}

function build($value, $node) {
    $model = new Envio;
    if (is_array($value) == true) {
        foreach ($value as $key => $element) {
            if ($key == '@attributes') {
                foreach ($element as $n => $v) {
                    $node->addAttribute($n, $v);
                }
            } else {
                $newNode = $node->addChild($key);
                $model->build($element, $newNode);
            }
        }
    } else {
        $node->nodeValue = $value;
    }
}

//function array_to_xml1(\SimpleXMLElement $object, array $data) {
//    foreach($data as $key => $value) {
//        if(is_array($value)) {
//            if(!is_numeric($key)){
//                $subnode = $xml->addChild("$key");
//            } else {
//                $subnode = $xml->addChild("value");
//                $subnode->addAttribute('key', $key);                    
//            }
//            $model->array_to_xml($value, $subnode);
//        }
//        else {
//            if (is_numeric($key)) {
//                $xml->addChild("value", $value)->addAttribute('key', $key);
//            } else {
//                $xml->addChild("$key",$value);
//            }
//        }
//    }
//} 
    
    
    
    
//    public function generarxml(){
////            $items = $item;
////            \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;            
////            return $items;
//        
//            $xmlValues = ['test1' => 'value1', 'test2' => 'value2'];
// 
//            //set content type xml in response
//            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//            $headers = Yii::$app->response->headers;
//            $headers->add('Content-Type', 'text/xml');
//            foreach($xmlValues as $key => $value){
//    echo '<setting id="'.$key.'">'.$value.'</settting>';
//}
            
//             \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
//            $items = ['some', 'array', 'of', 'data' => ['associative', 'array']];
//            return $items;
//    }


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
		if (isset($result->error)) throw new Exception('Error durante la respuesta: '.$result->error);

		return $result;
	}

	public function login() {
                $model = new Envio;
                
		$result = $model->request(array(
                    'action' => 'login', 
                    'login' => 'WEBSERVICE', 
                    'password' => 'webservice', 
                    'context' => 'pruebassri'));
		$sessionId = $result->session_id;
		return $sessionId;
	}

	public function sendDocuments($sessionId, $documents) {
                $model = new Envio;
		$result = $model->request(array('action' => 'putSriObjectsOffline', 'session_id' => $sessionId, 'records' => $documents));

		return array($result->records, $result->errors);
	}

	public function getProcessedDocuments($sessionId) {
                $model = new Envio;
		$result = $model->request(array('action' => 'getSriObjects', 'session_id' => $sessionId, 'filter' => array('process_status' => 1)));

		return $result->records;
	}

	public function hideDocuments($sessionId, $ids) {
                $model = new Envio;
		$model->request(array('action' => 'updateSriObjects', 'session_id' => $sessionId, 'process_status' => 2, 'ids' => $ids));
	}
}
