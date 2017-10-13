<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recarga".
 *
 * @property integer $id
 * @property string $valor_recarga
 * @property integer $user_id
 * @property string $fecha
 *
 * @property User $user
 */
class Recarga extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
//    public $bookingForm;
//    public $bookingForm;
//    public $bookingForm;
    
    
    public static function tableName()
    {
        return 'recarga';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor_recarga', 'user_id'], 'required'],
            [['valor_recarga'], 'number'],
            [['user_id'], 'integer'],
            [['fecha'], 'string', 'max' => 45],
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
            'valor_recarga' => Yii::t('app', 'Valor Recarga'),
            'user_id' => Yii::t('app', 'User ID'),
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
