<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "descuento".
 *
 * @property integer $id
 * @property string $codigo_descuento
 * @property string $valor_descuento
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $archivo_promocion
 *
 * @property DescuentoUsuario[] $descuentoUsuarios
 */
class Descuento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'descuento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo_descuento', 'valor_descuento', 'fecha_inicio', 'fecha_fin', 'archivo_promocion'], 'required'],
            [['valor_descuento'], 'number'],
            [['codigo_descuento', 'fecha_inicio', 'fecha_fin'], 'string', 'max' => 45],
//            [['archivo_promocion'], 'string', 'max' => 100],
            [['archivo_promocion'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo_descuento' => Yii::t('app', 'Codigo Descuento'),
            'valor_descuento' => Yii::t('app', 'Valor Descuento'),
            'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
            'fecha_fin' => Yii::t('app', 'Fecha Fin'),
            'archivo_promocion' => Yii::t('app', 'Archivo Promocion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescuentoUsuarios()
    {
        return $this->hasMany(DescuentoUsuario::className(), ['descuento_id' => 'id']);
    }
    
    /******************************************************************************************************/
    
    public function generarCodigo($longitud) {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++)
            $key .= $pattern{mt_rand(0, $max)};
        return $key;
    }
    
    public function check_in_range($start_date, $end_date, $evaluame) {
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($evaluame);
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

}
