<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promocion".
 *
 * @property integer $id
 * @property string $codigo_promocion
 * @property string $valor_promocion
 * @property string $valor_base
 * @property integer $limite
 * @property string $fecha_inicio
 * @property string $fecha_fin
 *
 * @property PromocionUsuario[] $promocionUsuarios
 */
class Promocion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promocion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo_promocion', 'valor_promocion', 'valor_base', 'limite', 'fecha_inicio', 'fecha_fin'], 'required'],
            [['valor_promocion', 'valor_base'], 'number'],
            [['limite'], 'integer'],
            [['codigo_promocion', 'fecha_inicio', 'fecha_fin'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo_promocion' => Yii::t('app', 'Codigo Promocion'),
            'valor_promocion' => Yii::t('app', 'Valor Promocion'),
            'valor_base' => Yii::t('app', 'Valor Base'),
            'limite' => Yii::t('app', 'Limite'),
            'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
            'fecha_fin' => Yii::t('app', 'Fecha Fin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromocionUsuarios()
    {
        return $this->hasMany(PromocionUsuario::className(), ['promocion_id' => 'id']);
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
