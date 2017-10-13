<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contactanos".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $email
 * @property string $telefono
 * @property integer $ciudad_id
 * @property string $tipo_mensaje
 * @property string $mensaje
 */
class Contactanos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contactanos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'email', 'telefono', 'ciudad_id', 'tipo_mensaje', 'mensaje'], 'required'],
            [['ciudad_id'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['email', 'tipo_mensaje'], 'string', 'max' => 45],
            [['telefono'], 'string', 'max' => 10],
            [['mensaje'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'email' => Yii::t('app', 'Email'),
            'telefono' => Yii::t('app', 'Telefono'),
            'ciudad_id' => Yii::t('app', 'Ciudad ID'),
            'tipo_mensaje' => Yii::t('app', 'Tipo Mensaje'),
            'mensaje' => Yii::t('app', 'Mensaje'),
        ];
    }
}
