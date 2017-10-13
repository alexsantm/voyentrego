<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "datos_vehiculo".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $marca
 * @property string $modelo
 * @property integer $anio
 * @property string $placa
 * @property integer $responsable_user_id
 * @property string $fecha
 * @property integer $estado_id
 *
 * @property Estado $estado
 * @property User $user
 */
class DatosVehiculo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'datos_vehiculo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'marca', 'modelo', 'placa', 'responsable_user_id', 'estado_id'], 'required'],
            [['user_id', 'anio', 'responsable_user_id', 'estado_id'], 'integer'],
            [['marca', 'modelo', 'fecha'], 'string', 'max' => 45],
            [['placa'], 'string', 'max' => 8],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['estado_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'marca' => Yii::t('app', 'Marca'),
            'modelo' => Yii::t('app', 'Modelo'),
            'anio' => Yii::t('app', 'Anio'),
            'placa' => Yii::t('app', 'Placa'),
            'responsable_user_id' => Yii::t('app', 'Responsable User ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'estado_id' => Yii::t('app', 'Estado ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
