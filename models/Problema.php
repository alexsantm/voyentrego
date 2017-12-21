<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "problema".
 *
 * @property integer $id
 * @property string $problema
 * @property integer $buscar_mensajero
 *
 * @property ReporteProblema[] $reporteProblemas
 */
class Problema extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'problema';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['problema', 'buscar_mensajero'], 'required'],
            [['buscar_mensajero'], 'integer'],
            [['problema'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'problema' => Yii::t('app', 'Problema'),
            'buscar_mensajero' => Yii::t('app', 'Buscar Mensajero'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReporteProblemas()
    {
        return $this->hasMany(ReporteProblema::className(), ['problema_id' => 'id']);
    }
}
