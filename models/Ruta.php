<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ruta".
 *
 * @property integer $id
 * @property string $ruta
 * @property string $fecha
 *
 * @property Asignacion[] $asignacions
 */
class Ruta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ruta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ruta', 'fecha'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ruta' => Yii::t('app', 'Ruta'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignacions()
    {
        return $this->hasMany(Asignacion::className(), ['ruta_id' => 'id']);
    }
}
