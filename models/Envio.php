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
            [['ciudad_id', 'user_id', 'remitente', 'direccion_origen', 'tipo_envio_id', 'dimensiones_id', 'fecha_registro'], 'required'],
            [['ciudad_id', 'user_id', 'estado_envio_id', 'tipo_envio_id', 'dimensiones_id', 'mensajero_id'], 'integer'],
            [['latitud', 'longitud', 'total_km', 'valor_total'], 'number'],
            [['remitente', 'direccion_origen', 'fecha_registro', 'fecha_fin_envio'], 'string', 'max' => 45],
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
}
