<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "opciones".
 *
 * @property integer $id
 * @property string $radio
 * @property integer $dia_pago_mensajeros
 * @property integer $envios_tomados_por_dia
 * @property string $foto_promocion
 */
class Opciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'opciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['radio', 'tiempo_refresco', 'frec_almacenamiento_stand_by','frec_envio_stand_by','frec_almacenamiento_reparto','frec_envio_reparto'], 'number'],
            [['dia_pago_mensajeros', 'envios_tomados_por_dia'], 'integer'],
            [['foto_promocion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'radio' => Yii::t('app', 'Radio'),
            'dia_pago_mensajeros' => Yii::t('app', 'Dia Pago Mensajeros'),
            'envios_tomados_por_dia' => Yii::t('app', 'Envios Tomados Por Dia'),
            'foto_promocion' => Yii::t('app', 'Foto Promocion'),
        ];
    }
}
