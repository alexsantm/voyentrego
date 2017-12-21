<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_pagos".
 *
 * @property integer $id
 * @property integer $mensajero_id
 * @property integer $envio_id
 * @property string $valor
 * @property string $porcentaje
 * @property integer $estado
 * @property string $fecha
 * @property integer $id_historial_pagos
 */
class DetallePagos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_pagos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mensajero_id', 'envio_id', 'valor', 'estado', 'fecha'], 'required'],
            [['mensajero_id', 'envio_id', 'estado', 'id_historial_pagos'], 'integer'],
            [['valor'], 'number'],
            [['porcentaje'], 'string', 'max' => 5],
            [['fecha'], 'string', 'max' => 45],
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
            'envio_id' => Yii::t('app', 'Envio ID'),
            'valor' => Yii::t('app', 'Valor'),
            'porcentaje' => Yii::t('app', 'Porcentaje'),
            'estado' => Yii::t('app', 'Estado'),
            'fecha' => Yii::t('app', 'Fecha'),
            'id_historial_pagos' => Yii::t('app', 'Id Historial Pagos'),
        ];
    }
}
