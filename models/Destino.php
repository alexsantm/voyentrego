<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "destino".
 *
 * @property integer $id
 * @property integer $ciudad_id
 * @property integer $envio_id
 * @property string $destinatario
 * @property string $direccion_destino
 * @property string $latitud
 * @property string $longitud
 * @property string $celular
 * @property string $fecha_registro
 * @property string $fecha_asignacion
 * @property string $fecha_finalizacion
 * @property string $kilometros
 * @property string $valor
 * @property string $observacion
 * @property integer $estado_envio_id
 * @property integer $retorno_destino_id
 * @property integer $retorno_inicio
 * @property integer $tipo_envio_id
 * @property integer $dimensiones_id
 *
 * @property Ciudad $ciudad
 * @property Dimensiones $dimensiones
 * @property Envio $envio
 * @property EstadoEnvio $estadoEnvio
 * @property TipoEnvio $tipoEnvio
 */
class Destino extends \yii\db\ActiveRecord
{
    public $destino_check;
    public $inicio_check;
    public $destino_opc;
//    public $default;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'destino';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ciudad_id', 'envio_id', 'destinatario', 'direccion_destino', 'celular', 'tipo_envio_id', 'dimensiones_id'], 'required'],
            [['ciudad_id', 'envio_id', 'estado_envio_id', 'retorno_destino_id',  'tipo_envio_id', 'dimensiones_id'], 'integer'],
            [['retorno_inicio'], 'safe'],
            [['latitud', 'longitud', 'kilometros', 'valor'], 'number'],
            [['destinatario', 'direccion_destino', 'fecha_registro', 'fecha_asignacion', 'fecha_finalizacion'], 'string', 'max' => 45],
            [['celular'], 'string', 'max' => 10],
            [['observacion'], 'string', 'max' => 100],
            [['ciudad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['ciudad_id' => 'id']],
            [['dimensiones_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dimensiones::className(), 'targetAttribute' => ['dimensiones_id' => 'id']],
            [['envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Envio::className(), 'targetAttribute' => ['envio_id' => 'id']],
            [['estado_envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoEnvio::className(), 'targetAttribute' => ['estado_envio_id' => 'id']],
            [['tipo_envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoEnvio::className(), 'targetAttribute' => ['tipo_envio_id' => 'id']],
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
            'envio_id' => Yii::t('app', 'Envio ID'),
            'destinatario' => Yii::t('app', 'Destinatario'),
            'direccion_destino' => Yii::t('app', 'Direccion Destino'),
            'latitud' => Yii::t('app', 'Latitud'),
            'longitud' => Yii::t('app', 'Longitud'),
            'celular' => Yii::t('app', 'Celular'),
            'fecha_registro' => Yii::t('app', 'Fecha Registro'),
            'fecha_asignacion' => Yii::t('app', 'Fecha Asignacion'),
            'fecha_finalizacion' => Yii::t('app', 'Fecha Finalizacion'),
            'kilometros' => Yii::t('app', 'Kilometros'),
            'valor' => Yii::t('app', 'Valor'),
            'observacion' => Yii::t('app', 'Observacion'),
            'estado_envio_id' => Yii::t('app', 'Estado Envio ID'),
            'retorno_destino_id' => Yii::t('app', 'Retorno Destino ID'),
            'retorno_inicio' => Yii::t('app', '¿Debe retornar al Destino?'),
            'tipo_envio_id' => Yii::t('app', 'Tipo Envio ID'),
            'dimensiones_id' => Yii::t('app', 'Dimensiones ID'),
//            'default' => Yii::t('app', 'Sin retornos'),
        ];
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
    public function getEnvio()
    {
        return $this->hasOne(Envio::className(), ['id' => 'envio_id']);
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
}

