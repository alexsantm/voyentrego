<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recarga_transferencia".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fecha
 * @property string $doc_referencia
 * @property string $valor
 * @property string $valor_promo
 * @property integer $estado_id
 * @property string $codigo_promocion
 */
class RecargaTransferencia extends \yii\db\ActiveRecord
{
    public $plan;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recarga_transferencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fecha', 'doc_referencia', 'valor', 'estado_id'], 'required'],
            [['user_id', 'estado_id'], 'integer'],
            [['valor', 'valor_promo'], 'number'],
            [['fecha'], 'string', 'max' => 45],
            [['doc_referencia'], 'string', 'max' => 100],
            
            [['plan'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'doc_referencia' => Yii::t('app', 'Doc Referencia'),
            'valor' => Yii::t('app', 'Valor'),
            'valor_promo' => Yii::t('app', 'Valor Promo'),
            'estado_id' => Yii::t('app', 'Estado ID'),
            'codigo_promocion' => Yii::t('app', 'Codigo Promocion'),
        ];
    }
    
        /******************************************************************************************/
    public function calculo_promocion($val, $cod_promo )
    {        
        //FALTA VALIDAR QUE SE HAYA INGREADO SOLO UNA VEZ EL CODIGO
        $valor= $val;
        $codigo_promocion = $cod_promo;
        $fecha_actual = date("Y-m-d");
        $user_id = Yii::$app->user->identity['id'];
                
        $consulta_promocion = Promocion::find()->where(['codigo_promocion'=>$codigo_promocion])->asArray()->one(); 
        $promo_id = $consulta_promocion['id'];      
            
        $promo_usuario = PromocionUsuario::find()->where(['promocion_id'=>$promo_id])->andWhere(['user_id'=>$user_id])->asArray()->count();
        
        $contador = Promocion::find()->where(['codigo_promocion'=>$codigo_promocion])->asArray()->count();
                
        //Limite de personas para la promocion
        $limite_personas = $consulta_promocion['limite_personas'];       
        $contador_personas_en_promocion = PromocionUsuario::find()->where(['promocion_id'=>$promo_id])->asArray()->count();
        

//        print_r($codigo_promocion); echo('<br>');
        echo('limite de personas: ');print_r($limite_personas); echo('<br>');
        echo('Contador de personas en promocion: ');print_r($contador_personas_en_promocion);echo('<br>');
//        die();    
        /*************************************/
        if($promo_usuario ==0){            //Evalua si el codigo ha sido utilizado anteriormente            
                if($contador==0){ 
                        $promocion = 0;
                        return $promocion;
                }
                else  if(($contador>0) && ($contador_personas_en_promocion <= $limite_personas)){    //Evalua si la promocion existe en la tabla Promocion
//                    print_r("contador de personas en promocion menor o igual que limite de personas"); die();
                        $consulta_promocion = Promocion::find()->where(['codigo_promocion'=>$codigo_promocion])->asArray()->one();            
                        $promo_id = $consulta_promocion['id'];
                        $user_id = Yii::$app->user->identity['id'];
                        $fecha_inicio = $consulta_promocion['fecha_inicio'];
                        $fecha_fin = $consulta_promocion['fecha_fin'];
                        $base = $consulta_promocion['valor_base'];
                        $valor_promocion = $consulta_promocion['valor_promocion'];
                        $limite = $consulta_promocion['limite'];
                        $model_promo = new Promocion();
                        $validacion_fecha = $model_promo->check_in_range($fecha_inicio, $fecha_fin, $fecha_actual);
                        if($validacion_fecha){
                            if($valor <$base){
                                $promocion = 0;                    
//                                echo('Valor menos que base'); print_r($promocion);   die();                  
                                return $promocion;
                            }
                            else{
                                $cociente = intdiv($valor, $base);
                                if($cociente>=$limite){
                                    $promocion = $limite * $valor_promocion;
//                                    echo('Modulo mayor o igual que limite'); print_r($cociente); print_r($promocion); die();
                                    $this->guardar_promocion_usuario($promo_id, $user_id, $fecha_actual);
                                    return $promocion;
                                }
                                else{
                                    $promocion = $cociente * $valor_promocion;
//                                    echo('Modulo menor que limite'); print_r($promocion); die();
                                    $this->guardar_promocion_usuario($promo_id, $user_id, $fecha_actual);
                                    return $promocion;
                                }                   
                            }                
                        }
                        else{
                            return Yii::$app->session->setFlash('danger', 'Fecha de registro fuera de rango de promocion');
                        }
                    }                    
                    else if(($contador>0) && ($contador_personas_en_promocion > $limite_personas)){ 
//                        print_r("contador de personas en promocion MAYOR o igual que limite de personas"); die();
                        return Yii::$app->session->setFlash('warning', 'ATENCION: Promoción agotada');
                    }                    
                    else{
//                        return "El codigo ingresado no pertenece a ninguna promocion";                       
                        return Yii::$app->session->setFlash('danger', 'El codigo ingresado no pertenece a ninguna promocion');
                    }            
        }
        else{
            return Yii::$app->session->setFlash('warning', 'ATENCION: Recarga exitosa, sin promoción debido a que el código ya ha sido utilizado anteriormente');
        }
        /*************************************/
//        }
//        else{
//            return Yii::$app->session->setFlash('warning', 'ATENCION: Promoción agotada');
//        }
        
    }
    
    
    public function guardar_promocion_usuario($prom_id, $us_id, $fech_actual){
        $promo_id = $prom_id;
        $user_id = $us_id;
        $fecha_actual=$fech_actual;
        $connection = Yii::$app->getDb();
                   $command = $connection->createCommand('                                   
                   INSERT INTO promocion_usuario (promocion_id, user_id, fecha)
                       values ("'.$promo_id.'",'.$user_id.',"'.$fecha_actual.'")
                   ');                   
        $resultado = $command->execute();        
    }
}
