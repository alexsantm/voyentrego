<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_envio".
 *
 * @property integer $id
 * @property string $tipo_envio
 *
 * @property Destino[] $destinos
 * @property Envio[] $envios
 */
class TipoEnvio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_envio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo_envio'], 'required'],
            [['tipo_envio'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tipo_envio' => Yii::t('app', 'Tipo Envio'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinos()
    {
        return $this->hasMany(Destino::className(), ['tipo_envio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnvios()
    {
        return $this->hasMany(Envio::className(), ['tipo_envio_id' => 'id']);
    }
}
