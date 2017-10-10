<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promocion_usuario".
 *
 * @property integer $id
 * @property integer $promocion_id
 * @property integer $user_id
 * @property string $fecha
 *
 * @property Promocion $promocion
 */
class PromocionUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promocion_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promocion_id', 'user_id', 'fecha'], 'required'],
            [['promocion_id', 'user_id'], 'integer'],
            [['fecha'], 'string', 'max' => 45],
            [['promocion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promocion::className(), 'targetAttribute' => ['promocion_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'promocion_id' => Yii::t('app', 'Promocion ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromocion()
    {
        return $this->hasOne(Promocion::className(), ['id' => 'promocion_id']);
    }
}
