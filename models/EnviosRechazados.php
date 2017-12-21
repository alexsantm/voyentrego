<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "envios_rechazados".
 *
 * @property integer $id
 * @property integer $envio_id
 * @property integer $mensajero_id
 * @property string $fecha
 */
class EnviosRechazados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'envios_rechazados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['envio_id', 'mensajero_id'], 'integer'],
            [['fecha'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'envio_id' => Yii::t('app', 'Envio ID'),
            'mensajero_id' => Yii::t('app', 'Mensajero ID'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }
}
