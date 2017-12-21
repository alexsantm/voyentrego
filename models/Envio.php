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
 * @property integer $tiempo_aproximado
 * @property integer $modo_envio
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
            [['ciudad_id', 'user_id', 'remitente', 'direccion_origen', 'tipo_envio_id', 'dimensiones_id'], 'required'],
            [['ciudad_id', 'user_id', 'estado_envio_id', 'tipo_envio_id', 'dimensiones_id', 'mensajero_id'], 'integer'],
            [['total_km', 'valor_total'], 'number'],
            
            [['latitude', 'longitude', 'latitud', 'longitud', 'fecha_registro', 'address'], 'safe'],
            
            [['remitente', 'direccion_origen', 'fecha_registro','fecha_asignacion_mensajero', 'fecha_fin_envio'], 'string', 'max' => 45],
            
            ['fecha_registro','validateDates'],
            
            [['celular'], 'string', 'max' => 10],
            [['observacion'], 'string', 'max' => 300],
            [['ciudad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['ciudad_id' => 'id']],
            [['dimensiones_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dimensiones::className(), 'targetAttribute' => ['dimensiones_id' => 'id']],
            [['estado_envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoEnvio::className(), 'targetAttribute' => ['estado_envio_id' => 'id']],
            [['tipo_envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoEnvio::className(), 'targetAttribute' => ['tipo_envio_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['mensajero_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['mensajero_id' => 'id']],
            
            [['tiempo_estimado'], 'number'],
            [['modo_envio'], 'integer'],
        ];
    }


public function validateDates(){
    $fecha_actual = date("Y-m-d");
     if(strtotime($this->fecha_registro) < strtotime($fecha_actual)){
//         print_r($fecha_actual);echo('<br>');
//         print_r($this->fecha_registro);echo('<br>');         
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
    
    
    
       public function algoritmoseleccionmensajero($radio, $envio_id, $mensajeros_disponibles, $latitud_origen, $longitud_origen, $total_km, $valor_km, $tiempo_estimado)
    {                
        $model = new \app\models\Envio;   
        $radio_en_km = $radio /1000;
        $id_usuario = Yii::$app->user->identity['id'];
                
//        1. CONSULTO SI EXISTEN MENSAJEROS DISPONIBLES($mensajeros_disponibles) (ESTO LO ENVIO DESDE ENVIO CONTROLLER)
//              SI NO EXISTEN MENSAJEROS DISPONIBLES, CAMBIO ESTADO DE MODO_ENVIO A 2, COLO MENSAJERO_ID COMO NULO PARA QUE APAREZCA EN LISTA DE ENVIOS POR TOMAR
         if(empty($mensajeros_disponibles)){
            echo('<div class="alert alert-danger"><span class="glyphicon glyphicon-time" style="font-size:24px;">Atencion</span><br><h5>No se encuentran mensajeros disponibles. En un momento un mensajero tomará su envio</h5></div>');
             \app\models\Envio::updateAll(['mensajero_id' => NULL, 'modo_envio'=>2], 'id = '. "'".$envio_id."'" );
        }
        else{
//        2. CALCULO DISTANCIA MENSAJEROS A ORIGEN
            foreach ($mensajeros_disponibles as $f) {
                    $latitud_destino = $f['latitud'];
                    $longitud_destino = $f['longitud'];   
                    $mensajero_id =$f['user_id'];                    

                    $valor_distancia = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_destino, $longitud_destino);
                    
//         3. GRABO EN TABLA TEMPORAL
                    $connection = Yii::$app->getDb();
                                 $command = $connection->createCommand('                                   
                                 INSERT INTO distancia_temp(mensajero_id, km)
                                 values ('.$mensajero_id.', '.$valor_distancia.')
                                 ');                   
                                 $resultado = $command->execute();         
            }
            
//          4. EXTRAIGO EL VALOR MINIMO DE KM
            //$valor_minimo = \app\models\DistanciaTemp::find()->select(['mensajero_id'])->min('km');
             $consulta = (new \yii\db\Query())
                    ->select(["t.mensajero_id"])
                    ->from('distancia_temp t') 
                    ->where('t.km =(SELECT MIN(km) FROM distancia_temp)')
                    ->one();                     
                    $mensajero_id =  $consulta['mensajero_id'];
            
//          5. CONSULTO TABLA FAVORITOS PARA EL USUARIO
            $favoritos = \app\models\Favoritos::find()->select('mensajero_id')->where(['user_id'=>$id_usuario])->asArray()->all();
            
//          6. SI NO EXISTE FAVORITOS, SACO EL DE MENOR DISTANCIA EN 4 Y MUESTRO
            if(empty($favoritos)){
//                                print_r("no hay favoritos"); die();
                    $mensajero = $model->detallesMensajero($mensajero_id, $envio_id);  
                    echo($mensajero);
                    //****************Registro de valor km y distancia***********************/
                    $model->registrokm($envio_id, $total_km, $valor_km, $tiempo_estimado);
                    //****************Registro de valor km y distancia***********************/
                                        
//                  6.1 ELIMINO TABLA TEMPORAL:
                    $x = Yii::$app->db->createCommand("DELETE FROM distancia_temp")->execute();                                         
                    return;
            }
//          7. SI EXISTE FAVORITOS
            else{               
                foreach($favoritos as $fav){                
//                  7.1 UBICO LOS FAVORITOS EN TABLA DE TRACKING
                    $favorito_id = $fav['mensajero_id'];                
                    $ubico_favoritos = \app\models\Tracking::find()->where(['user_id'=>$favorito_id])->asArray()->one();
                    $longitud_favorito = $ubico_favoritos['longitud'];  
                    $latitud_favorito = $ubico_favoritos['latitud'];
                    
//                  7.2 CALCULO DISTANCIA DE FAVORITOS
                    $valor_distancia = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_favorito, $longitud_favorito);
                    
//                  7.3 GUARDO EN TABLA DISTANCIA FAVORITOS TEMPORAL
                    $model_fav= new DistanciaFavoritosTemp();
                    $model_fav->mensajero_id = $favorito_id;
                    $model_fav->km = $valor_distancia;
                    $model_fav->save();                    
                } 
                
//                  7.4 EXTRAIGO EL DE MENOR DISTANCIA Y MUESTRO
                    $consulta = (new \yii\db\Query())
                    ->select(["t.mensajero_id"])
                    ->from('distancia_favoritos_temp t') 
                    ->where('t.km =(SELECT MIN(km) FROM distancia_favoritos_temp)')
                    ->one();                     
                    $favorito_id =  $consulta['mensajero_id'];
                                                                              
//                  7.4.1 MUESTRO EL MENSAJERO:
                    $mensajero = $model->detallesMensajero($favorito_id, $envio_id);  
                    echo($mensajero);
                    //****************Registro de valor km y distancia***********************/
                    $model->registrokm($envio_id, $total_km, $valor_km, $tiempo_estimado);
                    //****************Registro de valor km y distancia***********************/
                                        
//                  7.4.2 ELIMINO DATOS DE TABLA TEMPORAL FAVORITOS
                    $x = Yii::$app->db->createCommand("DELETE FROM distancia_favoritos_temp")->execute();
                    
                    return;
            }
        }    
    }
    
     public function algoritmoseleccionotromensajero($mensajero_id_actual, $radio, $envio_id, $latitud_origen, $longitud_origen, $total_km, $valor_km, $tiempo_estimado)
    {                
        $model = new \app\models\Envio;   
        $radio_en_km = $radio /1000;
        $id_usuario = Yii::$app->user->identity['id'];
                
//        1. CONSULTO TODOS LOS MENSAJEROS ($mensajeros) (EXCEPTO EL ID DEL MENSAJERO ACTUAL ENVIADO DESDE MOVIL)
            $mensajero_id_actual = 11; //===> cambiar por el id enviado desde movil
           
            //Mensajeros con status 1 (Disponible)
            $mensajeros_disponibles = (new \yii\db\Query())
            ->select(['t1.id', 't1.user_id', 't1.longitud', 't1.latitud', 't1.fecha'])
            ->from('tracking t1, user u')
            ->where('t1.fecha = (SELECT MAX(t2.fecha)FROM tracking t2 WHERE t2.user_id = t1.user_id1)and t1.user_id <> '.$mensajero_id_actual.'')
            ->andWhere('u.id = t1.user_id')
            ->andWwhere('u.status_id = 1')
            ->all();
            
//        1.1  SI NO EXISTEN MENSAJEROS DISPONIBLES, CAMBIO ESTADO DE MODO_ENVIO A 2, COLO MENSAJERO_ID COMO NULO PARA QUE APAREZCA EN LISTA DE ENVIOS POR TOMAR
         if(empty($mensajeros_disponibles)){
            echo('<div class="alert alert-danger"><h3>Atención</h3><br><h5>No se encuentran mensajeros disponibles. En un momento un mensajero tomará su envio</h5></div>');
             \app\models\Envio::updateAll(['mensajero_id' => NULL, 'modo_envio'=>2], 'id = '. "'".$envio_id."'" );
        }
        else{  

//        2. CALCULO DISTANCIA MENSAJEROS A ORIGEN
            foreach ($mensajeros_disponibles as $f) {
                    $latitud_destino = $f['latitud'];
                    $longitud_destino = $f['longitud'];   
                    $mensajero_id =$f['user_id'];                    

                    $valor_distancia = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_destino, $longitud_destino);
                    
//         3. GRABO EN TABLA TEMPORAL
                    $connection = Yii::$app->getDb();
                                 $command = $connection->createCommand('                                   
                                 INSERT INTO distancia_temp(mensajero_id, km)
                                 values ('.$mensajero_id.', '.$valor_distancia.')
                                 ');                   
                                 $resultado = $command->execute();         
            }
            
//          4. EXTRAIGO EL VALOR MINIMO DE KM
            //$valor_minimo = \app\models\DistanciaTemp::find()->select(['mensajero_id'])->min('km');
             $consulta = (new \yii\db\Query())
                    ->select(["t.mensajero_id"])
                    ->from('distancia_temp t') 
                    ->where('t.km =(SELECT MIN(km) FROM distancia_temp)')
                    ->one();                     
                    $mensajero_id =  $consulta['mensajero_id'];
            
//          5. CONSULTO TABLA FAVORITOS PARA EL USUARIO
            $favoritos = \app\models\Favoritos::find()->select('mensajero_id')->where(['user_id'=>$id_usuario])->asArray()->all();
            
//          6. SI NO EXISTE FAVORITOS, SACO EL DE MENOR DISTANCIA EN 4 Y MUESTRO
            if(empty($favoritos)){
//                                print_r("no hay favoritos"); die();
                    $mensajero = $model->detallesMensajero($mensajero_id, $envio_id);  
                    echo($mensajero);
                    //****************Registro de valor km y distancia***********************/
                    $model->registrokm($envio_id, $total_km, $valor_km, $tiempo_estimado);
                    //****************Registro de valor km y distancia***********************/
                                        
//                  6.1 ELIMINO TABLA TEMPORAL:
                    $x = Yii::$app->db->createCommand("DELETE FROM distancia_temp")->execute();
                                         
                    return;
            }
//          7. SI EXISTE FAVORITOS
            else{               
                foreach($favoritos as $fav){                
//                  7.1 UBICO LOS FAVORITOS EN TABLA DE TRACKING
                    $favorito_id = $fav['mensajero_id'];                
                    $ubico_favoritos = \app\models\Tracking::find()->where(['user_id'=>$favorito_id])->asArray()->one();
                    $longitud_favorito = $ubico_favoritos['longitud'];  
                    $latitud_favorito = $ubico_favoritos['latitud'];
                    
//                  7.2 CALCULO DISTANCIA DE FAVORITOS
                    $valor_distancia = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_favorito, $longitud_favorito);
                    
//                  7.3 GUARDO EN TABLA DISTANCIA FAVORITOS TEMPORAL
                    $model_fav= new DistanciaFavoritosTemp();
                    $model_fav->mensajero_id = $favorito_id;
                    $model_fav->km = $valor_distancia;
                    $model_fav->save();                    
                } 
                
//                  7.4 EXTRAIGO EL DE MENOR DISTANCIA Y MUESTRO
                    $consulta = (new \yii\db\Query())
                    ->select(["t.mensajero_id"])
                    ->from('distancia_favoritos_temp t') 
                    ->where('t.km =(SELECT MIN(km) FROM distancia_favoritos_temp)')
                    ->one();                     
                    $favorito_id =  $consulta['mensajero_id'];
                                                                              
//                  7.4.1 MUESTRO EL MENSAJERO:
                    $mensajero = $model->detallesMensajero($favorito_id, $envio_id);  
                    echo($mensajero);
                    //****************Registro de valor km y distancia***********************/
                    $model->registrokm($envio_id, $total_km, $valor_km, $tiempo_estimado);
                    //****************Registro de valor km y distancia***********************/
                                        
//                  7.4.2 ELIMINO DATOS DE TABLA TEMPORAL FAVORITOS
                    $x = Yii::$app->db->createCommand("DELETE FROM distancia_favoritos_temp")->execute();
                    
                    return;
            }  
        }    
    }
    
    
//     public function algoritmoseleccionmensajerorecurrente($radio, $envio_id, $mensajeros, $latitud_origen, $longitud_origen, $total_km, $valor_km, $tiempo_estimado, $envios)
//    {                
//        $model = new \app\models\Envio;   
//        $radio_en_km = $radio /1000;
//        $id_usuario = Yii::$app->user->identity['id'];
//                
////        1. CONSULTO TODOS LOS MENSAJEROS ($mensajeros) (ESTO LO ENVIO DESDE ENVIO CONTROLLER)
////        2. CACLULO DISTANCIA MENSAJEROS A ORIGEN
//            foreach ($mensajeros as $f) {
//                    $latitud_destino = $f['latitud'];
//                    $longitud_destino = $f['longitud'];   
//                    $mensajero_id =$f['user_id'];                    
//
//                    $valor_distancia = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_destino, $longitud_destino);
//                    
////         3. GRABO EN TABLA TEMPORAL
//                    $connection = Yii::$app->getDb();
//                                 $command = $connection->createCommand('                                   
//                                 INSERT INTO distancia_temp(mensajero_id, km)
//                                 values ('.$mensajero_id.', '.$valor_distancia.')
//                                 ');                   
//                                 $resultado = $command->execute();         
//            }
//            
////          4. EXTRAIGO EL VALOR MINIMO DE KM
//            //$valor_minimo = \app\models\DistanciaTemp::find()->select(['mensajero_id'])->min('km');
//             $consulta = (new \yii\db\Query())
//                    ->select(["t.mensajero_id"])
//                    ->from('distancia_temp t') 
//                    ->where('t.km =(SELECT MIN(km) FROM distancia_temp)')
//                    ->one();                     
//                    $mensajero_id =  $consulta['mensajero_id'];
//            
////          5. CONSULTO TABLA FAVORITOS PARA EL USUARIO
//            $favoritos = \app\models\Favoritos::find()->select('mensajero_id')->where(['user_id'=>$id_usuario])->asArray()->all();
//            
////          6. SI NO EXISTE FAVORITOS, SACO EL DE MENOR DISTANCIA EN 4 Y MUESTRO
//            if(empty($favoritos)){
////                                print_r("no hay favoritos"); die();
//                    $mensajero = $model->detallesMensajerorecurrente($mensajero_id, $envio_id, $envios);  
//                    echo($mensajero);
//                    //****************Registro de valor km y distancia***********************/
//                    $model->registrokmrecurrente($envio_id, $total_km, $valor_km, $tiempo_estimado, $envios);
//                    //****************Registro de valor km y distancia***********************/
//                                        
////                  6.1 ELIMINO TABLA TEMPORAL:
//                    $x = Yii::$app->db->createCommand("DELETE FROM distancia_temp")->execute();
//                                         
//                    return;
//            }
////          7. SI EXISTE FAVORITOS
//            else{               
//                foreach($favoritos as $fav){                
////                    print_r("si hay favoritos");die();
////                  7.1 UBICO LOS FAVORITOS EN TABLA DE TRACKING
//                    $favorito_id = $fav['mensajero_id'];                
//                    $ubico_favoritos = \app\models\Tracking::find()->where(['user_id'=>$favorito_id])->asArray()->one();
//                    $longitud_favorito = $ubico_favoritos['longitud'];  
//                    $latitud_favorito = $ubico_favoritos['latitud'];
//                    
////                  7.2 CALCULO DISTANCIA DE FAVORITOS
//                    $valor_distancia = $model->calculo_distancia($latitud_origen, $longitud_origen, $latitud_favorito, $longitud_favorito);
//                    
////                  7.3 GUARDO EN TABLA DISTANCIA FAVORITOS TEMPORAL
//                    $model_fav= new DistanciaFavoritosTemp();
//                    $model_fav->mensajero_id = $favorito_id;
//                    $model_fav->km = $valor_distancia;
//                    $model_fav->save();                    
//                } 
//                
////                  7.4 EXTRAIGO EL DE MENOR DISTANCIA Y MUESTRO
//                    $consulta = (new \yii\db\Query())
//                    ->select(["t.mensajero_id"])
//                    ->from('distancia_favoritos_temp t') 
//                    ->where('t.km =(SELECT MIN(km) FROM distancia_favoritos_temp)')
//                    ->one();                     
//                    $favorito_id =  $consulta['mensajero_id'];
//                                                                              
////                  7.4.1 MUESTRO EL MENSAJERO:
//                    $mensajero = $model->detallesMensajerorecurrente($favorito_id, $envio_id);  
//                    echo($mensajero);
//                    //****************Registro de valor km y distancia***********************/
//                    $model->registrokmrecurrente($envio_id, $total_km, $valor_km, $tiempo_estimado);
//                    //****************Registro de valor km y distancia***********************/
//                                        
////                  7.4.2 ELIMINO DATOS DE TABLA TEMPORAL FAVORITOS
//                    $x = Yii::$app->db->createCommand("DELETE FROM distancia_favoritos_temp")->execute();
//                    
//                    return;
//            }  
//    }
    
    public function tiempoestimado ($envio_id){
                    //ORIGEN
            $query = \app\models\Envio::find()->select(['latitud', 'longitud'])->where(['id'=>$envio_id])->asArray()->one();
            $latitud_origen = $query['latitud'];
            $longitud_origen = $query['longitud'];
            $origin = array($latitud_origen, $longitud_origen);
            $origen = implode(",",$origin);

            //DESTINOS
            $destinos = \app\models\Destino::find()->where(['envio_id'=>$envio_id])->asArray()->all();
            foreach($destinos as $d){         
                    $lat=$d['latitud'];
                    $long=$d['longitud'];
                    $array = array($lat, $long); 
                    $array2[]=$array;
            }
            foreach($array2 as $a){         
                $way[] = implode(",",$a);
            }
            $waypoints = implode("|",$way);
            $response = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.$origen.'&destinations='.$waypoints.'&key=AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8');            
            $response  = json_decode($response, TRUE);            
            $segundos =0;           
            $respuesta = $response['rows'];
            
            
            
             foreach($respuesta as $r){
                 $respuesta1 = $r['elements'];                                      
                 foreach($respuesta1 as $r1){                              
//                    if(empty($r1['duration']['value'])){
//                        ?><?php // Yii::$app->session->setFlash('danger', '<h4>ERROR EN DESTINO</h4> Debe registrar un destino para poder continuar');  ?><?php  
//                        return Yii::$app->response->redirect(Yii::$app->request->referrer);                        
//                    } 

                        $valor = $r1['duration']['value'];                    
                        $segundos += $valor;
                }                 
             }             
            //print_r($response['rows']); 
             if(!empty($segundos)){
                $minutos = ($segundos/60);
             }else{
                 $minutos = 0;
             }             
             return $tiempo_estimado = round( $minutos, 1, PHP_ROUND_HALF_UP);
    }
    
        public function detallesMensajero($id, $env_id)
    {
        $envio_id = $env_id;
        $mensajero_id = $id;
        $det = \app\models\Profile::find()->where(['user_id'=>$mensajero_id])->asArray()->one();
        $nombre = $det['full_name'];
        $celular = $det['telefono'];
//        print_r($mensajero_id);
        
//        Datos Vehiculo
        $datos_vehiculo = \app\models\DatosVehiculo::find()->where(['user_id'=>$mensajero_id])->asArray()->one();
            $marca_vehiculo = $datos_vehiculo['marca'];
            $modelo_vehiculo = $datos_vehiculo['modelo'];
            $placa = $datos_vehiculo['placa'];
        
        if(empty($marca_vehiculo)){ $marca_vehiculo ="No asignado";}
        if(empty($modelo_vehiculo)){ $modelo_vehiculo ="No asignado";}
        if(empty($placa)){ $placa ="No asignado";}
        
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
                        <p><h4 style='display: inline;' ><strong>Nombre: </strong></h4> ".$nombre.".</p>
                        <p><h4 style='display: inline;' ><strong>Telefono:</strong></h4> ".$celular.".</p>
                        <p><h3>Detalles de Vehículo</h3></p>
                        <p><h4 style='display: inline;' ><strong>Marca:</strong></h4> ".$marca_vehiculo.".</p>
                        <p><h4 style='display: inline;' ><strong>Modelo:</strong></h4> ".$modelo_vehiculo.".</p>
                        <p><h4 style='display: inline;' ><strong>Placa:</strong></h4> ".$placa.".</p>
                    </div>
                    <div class='col-lg-7' style='padding:10px 10px;'>
                            <img src=".$foto." class='rounded sombra' alt='Responsive image' style='width:175px; height: 175px;'>
                    </div><br>
                </div></center>
                ";
        
    //Actualizo datos de mensajero:
        $fecha = date("Y-m-d H:i");
        \app\models\Envio::updateAll(['mensajero_id' => $mensajero_id, 'fecha_asignacion_mensajero'=>$fecha], 'id = '. "'".$envio_id."'" );   
        //\app\models\Envio::updateAll(['mensajero_id' => $mensajero_id], 'id = '. "'".$envio_id."'" );   
        
        return $htmlMsg;
    }
    
            public function detallesMensajerorecurrente($id, $env_id, $envios)
    {
        $envio_id = $env_id;
        $mensajero_id = $id;
        $det = \app\models\Profile::find()->where(['user_id'=>$mensajero_id])->asArray()->one();
        $nombre = $det['full_name'];
        $celular = $det['telefono'];
//        print_r($mensajero_id);
        
//        Datos Vehiculo
        $datos_vehiculo = \app\models\DatosVehiculo::find()->where(['user_id'=>$mensajero_id])->asArray()->one();
            $marca_vehiculo = $datos_vehiculo['marca'];
            $modelo_vehiculo = $datos_vehiculo['modelo'];
            $placa = $datos_vehiculo['placa'];
        
        if(empty($marca_vehiculo)){ $marca_vehiculo ="No asignado";}
        if(empty($modelo_vehiculo)){ $modelo_vehiculo ="No asignado";}
        if(empty($placa)){ $placa ="No asignado";}
        
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
                        <p><h4 style='display: inline;' ><strong>Nombre: </strong></h4> ".$nombre.".</p>
                        <p><h4 style='display: inline;' ><strong>Telefono:</strong></h4> ".$celular.".</p>
                        <p><h3>Detalles de Vehículo</h3></p>
                        <p><h4 style='display: inline;' ><strong>Marca:</strong></h4> ".$marca_vehiculo.".</p>
                        <p><h4 style='display: inline;' ><strong>Modelo:</strong></h4> ".$modelo_vehiculo.".</p>
                        <p><h4 style='display: inline;' ><strong>Placa:</strong></h4> ".$placa.".</p>
                    </div>
                    <div class='col-lg-7' style='padding:10px 10px;'>
                            <img src=".$foto." class='rounded sombra' alt='Responsive image' style='width:175px; height: 175px;'>
                    </div><br>
                </div></center>
                ";
        
    //Actualizo datos de mensajero:
        $fecha = date("Y-m-d H:i");
          
        
        
        $cont = 0;
            while($cont < count($envios)){   
                \app\models\Envio::updateAll(['mensajero_id' => $mensajero_id, 'fecha_asignacion_mensajero'=>$fecha], 'id = '. "'".$envios[$cont]."'" );   
                $cont = $cont+1;
            } 
            return;
        
        //\app\models\Envio::updateAll(['mensajero_id' => $mensajero_id], 'id = '. "'".$envio_id."'" );   
        
        return $htmlMsg;
    }
    
    
    
    public function registrokm($id, $totalkm, $valorkm, $tiempoestimado)
    {                
        $envio_id = $id;
        $total_km = $totalkm;
        $valor_total = $valorkm;
        $tiempo_estimado = $tiempoestimado;
        
//        print_r("ingrese a funcion registrokm"); die();
       
        \app\models\Envio::updateAll([
            'total_km' => $total_km, 
            'valor_total' => $valor_total,
            'tiempo_estimado' => $tiempo_estimado,
            'estado_envio_id'=>2
            ], 'id = '. "'".$envio_id."'" );        
        return;
    }
    
      public function registrokmrecurrente($id, $totalkm, $valorkm, $tiempoestimado, $envios)
    {                
        $envio_id = $id;
        $total_km = $totalkm;
        $valor_total = $valorkm;
        $tiempo_estimado = $tiempoestimado;
//        print_r(count($envios)); die();
            $cont = 0;
            while($cont < count($envios)){   
                            \app\models\Envio::updateAll([
                                'total_km' => $total_km, 
                                'valor_total' => $valor_total,
                                'tiempo_estimado' => $tiempo_estimado,
                                'estado_envio_id'=>2
                                ], 'id = '. "'".$envios[$cont]."'" );        
                    $cont = $cont+1;
            } 
            return;
    }
    
            public function actualizarecarga($valorkm)
    {                
        $user_id = Yii::$app->user->identity['id'];
        $query= Recarga::find()->select(['valor_recarga'])->where(['user_id'=>$user_id])->asArray()->one();
        $valor_actual_recarga = $query['valor_recarga'];
        $valor_a_actualizar = floatval($valor_actual_recarga) - floatval($valorkm);
        
        if($valor_a_actualizar < 0){
            return "El valor de recarga es insuficiente para proceder";
        }
               
        \app\models\Recarga::updateAll([
            'valor_recarga' => $valor_a_actualizar
            ], 'user_id = '. "'".$user_id."'" );        
        return;
    }
    
     public function Matchmensajero($envio_id){   
    if(!empty($envio_id)){        
        $key = true;
        while($key = true){   
            $query = \app\models\Envio::find()->select(['mensajero_id'])
                    ->where(['id'=>$envio_id])
                    ->andWhere(['not',['mensajero_id' => null]])
                    ->asArray()->one(); 
            if(!empty($query)){              
                    $key = false;
                    return $query['mensajero_id'];
                    break;
            }               
        }         
    }
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

/********************************************************************* VERIFICACION DE ACCESOS*********************************************/      
            public function verificar_acceso($r, $rt)
    {                
        $rol = $r;
        $ruta = $rt;
        
        $query_ruta = \app\models\Ruta::find()->where(['ruta'=>$ruta])->asArray()->one();
        $ruta_id=$query_ruta['id'];
        $query= \app\models\Asignacion::find()->where(['role_id'=>$rol, 'ruta_id'=>$ruta_id])->asArray()->one();
        
        if(!empty($query)){            
            return 1;
        }
        else{
            return 0;
        }        
    }
    


    
    
}
