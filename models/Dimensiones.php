<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimensiones".
 *
 * @property integer $id
 * @property string $dimension
 *
 * @property Destino[] $destinos
 * @property Envio[] $envios
 */
class Dimensiones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dimensiones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dimension'], 'required'],
            [['dimension'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'dimension' => Yii::t('app', 'Dimension'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinos()
    {
        return $this->hasMany(Destino::className(), ['dimensiones_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnvios()
    {
        return $this->hasMany(Envio::className(), ['dimensiones_id' => 'id']);
    }
}
