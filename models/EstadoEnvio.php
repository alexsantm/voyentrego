<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estado_envio".
 *
 * @property integer $id
 * @property string $estado
 *
 * @property Destino[] $destinos
 * @property Envio[] $envios
 */
class EstadoEnvio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estado_envio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinos()
    {
        return $this->hasMany(Destino::className(), ['estado_envio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnvios()
    {
        return $this->hasMany(Envio::className(), ['estado_envio_id' => 'id']);
    }
}
