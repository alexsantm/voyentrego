<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "envio".
 *
 * @property integer $id
 * @property integer $ciudad_id
 * @property integer $user_id
 * @property string $remitente
 * @property string $direccion_origen
 * @property string $latitud
 * @property string $longitud
 * @property string $celular
 * @property string $fecha_registro
 * @property string $fecha_fin_envio
 * @property string $total_km
 * @property string $valor_total
 * @property string $observacion
 * @property integer $estado_envio_id
 * @property integer $tipo_envio_id
 * @property integer $dimensiones_id
 * @property integer $mensajero_id
 *
 * @property Destino[] $destinos
 * @property DetalleFactura[] $detalleFacturas
 * @property Ciudad $ciudad
 * @property Dimensiones $dimensiones
 * @property EstadoEnvio $estadoEnvio
 * @property TipoEnvio $tipoEnvio
 * @property User $user
 * @property User $mensajero
 */
class Envio extends \yii\db\ActiveRecord
{
        public $address;
    public $longitude;
    public $latitude;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'envio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ciudad_id', 'user_id', 'remitente', 'direccion_origen', 'tipo_envio_id', 'dimensiones_id'], 'required'],
            [['ciudad_id', 'user_id', 'estado_envio_id', 'tipo_envio_id', 'dimensiones_id', 'mensajero_id'], 'integer'],
            [['latitud', 'longitud', 'total_km', 'valor_total'], 'number'],
            [['remitente', 'direccion_origen', 'fecha_registro', 'fecha_fin_envio'], 'string', 'max' => 45],
            [['celular'], 'string', 'max' => 10],
            [['observacion'], 'string', 'max' => 300],
            [['ciudad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['ciudad_id' => 'id']],
            [['dimensiones_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dimensiones::className(), 'targetAttribute' => ['dimensiones_id' => 'id']],
            [['estado_envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoEnvio::className(), 'targetAttribute' => ['estado_envio_id' => 'id']],
            [['tipo_envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoEnvio::className(), 'targetAttribute' => ['tipo_envio_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['mensajero_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['mensajero_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ciudad_id' => Yii::t('app', 'Ciudad ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'remitente' => Yii::t('app', 'Remitente'),
            'direccion_origen' => Yii::t('app', 'Direccion Origen'),
            'latitud' => Yii::t('app', 'Latitud'),
            'longitud' => Yii::t('app', 'Longitud'),
            'celular' => Yii::t('app', 'Celular'),
            'fecha_registro' => Yii::t('app', 'Fecha Registro'),
            'fecha_fin_envio' => Yii::t('app', 'Fecha Fin Envio'),
            'total_km' => Yii::t('app', 'Total Km'),
            'valor_total' => Yii::t('app', 'Valor Total'),
            'observacion' => Yii::t('app', 'Observacion'),
            'estado_envio_id' => Yii::t('app', 'Estado Envio ID'),
            'tipo_envio_id' => Yii::t('app', 'Tipo Envio ID'),
            'dimensiones_id' => Yii::t('app', 'Dimensiones ID'),
            'mensajero_id' => Yii::t('app', 'Mensajero ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinos()
    {
        return $this->hasMany(Destino::className(), ['envio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleFacturas()
    {
        return $this->hasMany(DetalleFactura::className(), ['envio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['id' => 'ciudad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDimensiones()
    {
        return $this->hasOne(Dimensiones::className(), ['id' => 'dimensiones_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoEnvio()
    {
        return $this->hasOne(EstadoEnvio::className(), ['id' => 'estado_envio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoEnvio()
    {
        return $this->hasOne(TipoEnvio::className(), ['id' => 'tipo_envio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajero()
    {
        return $this->hasOne(User::className(), ['id' => 'mensajero_id']);
    }
}
