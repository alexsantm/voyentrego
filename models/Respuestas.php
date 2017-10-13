<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuestas".
 *
 * @property integer $id
 * @property string $respuesta
 * @property integer $preguntas_frecuentes_id
 * @property string $fecha
 *
 * @property PreguntasFrecuentes $preguntasFrecuentes
 */
class Respuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'respuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['respuesta', 'preguntas_frecuentes_id', 'fecha'], 'required'],
            [['preguntas_frecuentes_id'], 'integer'],
            [['respuesta'], 'string', 'max' => 200],
            [['fecha'], 'string', 'max' => 20],
            [['preguntas_frecuentes_id'], 'exist', 'skipOnError' => true, 'targetClass' => PreguntasFrecuentes::className(), 'targetAttribute' => ['preguntas_frecuentes_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'respuesta' => Yii::t('app', 'Respuesta'),
            'preguntas_frecuentes_id' => Yii::t('app', 'Preguntas Frecuentes ID'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntasFrecuentes()
    {
        return $this->hasOne(PreguntasFrecuentes::className(), ['id' => 'preguntas_frecuentes_id']);
    }
}
