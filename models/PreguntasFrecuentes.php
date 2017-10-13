<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preguntas_frecuentes".
 *
 * @property integer $id
 * @property string $pregunta_frecuente
 * @property string $fecha
 *
 * @property Respuestas[] $respuestas
 */
class PreguntasFrecuentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preguntas_frecuentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pregunta_frecuente'], 'required'],
            [['pregunta_frecuente'], 'string', 'max' => 100],
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
            'pregunta_frecuente' => Yii::t('app', 'Pregunta Frecuente'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(Respuestas::className(), ['preguntas_frecuentes_id' => 'id']);
    }
}
