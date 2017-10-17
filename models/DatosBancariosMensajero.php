<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "datos_bancarios_mensajero".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $tipo_transferencia
 * @property string $numero_cuenta
 * @property string $nombre_banco
 * @property string $nombre_completo
 * @property string $identificacion
 * @property string $email
 * @property string $fecha
 *
 * @property User $user
 */
class DatosBancariosMensajero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $tipo;
    
    public static function tableName()
    {
        return 'datos_bancarios_mensajero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tipo_transferencia', 'fecha'], 'required'],
            [['user_id'], 'integer'],
            [['tipo_transferencia'], 'string', 'max' => 20],
            [['fecha'], 'string'],
            [['numero_cuenta', 'identificacion'], 'string', 'max' => 10],
            [['nombre_banco', 'email'], 'string', 'max' => 45],
            [['nombre_completo'], 'string', 'max' => 100],
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
            'tipo_transferencia' => Yii::t('app', 'Tipo Transferencia'),
            'numero_cuenta' => Yii::t('app', 'Numero Cuenta'),
            'nombre_banco' => Yii::t('app', 'Nombre Banco'),
            'nombre_completo' => Yii::t('app', 'Nombre Completo'),
            'identificacion' => Yii::t('app', 'Identificacion'),
            'email' => Yii::t('app', 'Email'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
