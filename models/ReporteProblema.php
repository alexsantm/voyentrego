<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reporte_problema".
 *
 * @property integer $id
 * @property integer $envio_id
 * @property integer $user_id
 * @property integer $problema_id
 * @property string $fecha
 * @property string $imagen
 *
 * @property Envio $envio
 * @property Problema $problema
 * @property User $user
 */
class ReporteProblema extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reporte_problema';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['envio_id', 'user_id', 'problema_id'], 'required'],
            [['envio_id', 'user_id', 'problema_id'], 'integer'],
            [['fecha'], 'string', 'max' => 45],
            [['imagen'], 'string', 'max' => 100],
            [['envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Envio::className(), 'targetAttribute' => ['envio_id' => 'id']],
            [['problema_id'], 'exist', 'skipOnError' => true, 'targetClass' => Problema::className(), 'targetAttribute' => ['problema_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'problema_id' => Yii::t('app', 'Problema ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'imagen' => Yii::t('app', 'Imagen'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnvio()
    {
        return $this->hasOne(Envio::className(), ['id' => 'envio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProblema()
    {
        return $this->hasOne(Problema::className(), ['id' => 'problema_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
