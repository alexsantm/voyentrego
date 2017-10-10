<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "descuento_usuario".
 *
 * @property integer $id
 * @property integer $descuento_id
 * @property integer $user_id
 * @property string $fecha
 *
 * @property Descuento $descuento
 */
class DescuentoUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'descuento_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descuento_id', 'user_id', 'fecha'], 'required'],
            [['descuento_id', 'user_id'], 'integer'],
            [['fecha'], 'string', 'max' => 45],
            [['descuento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Descuento::className(), 'targetAttribute' => ['descuento_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descuento_id' => Yii::t('app', 'Descuento ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDescuento()
    {
        return $this->hasOne(Descuento::className(), ['id' => 'descuento_id']);
    }
}
