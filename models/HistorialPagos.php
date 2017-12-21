<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historial_pagos".
 *
 * @property integer $id
 * @property integer $mensajero_id
 * @property string $valor
 * @property string $fecha
 * @property integer $estado
 * @property integer $referencia
 */
class HistorialPagos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'historial_pagos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mensajero_id', 'valor', 'fecha', 'estado'], 'required'],
            [['mensajero_id', 'estado'], 'integer'],
            [['valor'], 'number'],
            [['fecha'], 'string', 'max' => 45],
            
            [['referencia'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mensajero_id' => Yii::t('app', 'Mensajero ID'),
            'valor' => Yii::t('app', 'Valor'),
            'fecha' => Yii::t('app', 'Fecha'),
            'estado' => Yii::t('app', 'Estado'),
        ];
    }
    
    public function actualizaIdPagos($user_id){
            $query = HistorialPagos::find()
            ->where(['estado'=>4])
            ->andWhere(['mensajero_id'=>$user_id]) 
            ->orderBy('fecha DESC')
            ->limit(1)
            ->asArray()->one();                                        
            $id_historial_pagos = $query['id'];
            \app\models\DetallePagos::updateAll(['id_historial_pagos' =>$id_historial_pagos, 'estado'=>4], 'mensajero_id = '. "'".$user_id."'".' and '. 'estado  <> 4');                                           
    }

}
