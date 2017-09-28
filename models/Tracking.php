<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tracking".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $longitud
 * @property string $latitud
 * @property string $fecha
 * @property string $exactitud
 *
 * @property User $user
 */
class Tracking extends \yii\db\ActiveRecord
{
    
      public $address;
    public $longitude;
    public $latitude;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tracking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['longitud', 'latitud', 'exactitud'], 'number'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'longitud' => Yii::t('app', 'Longitud'),
            'latitud' => Yii::t('app', 'Latitud'),
            'fecha' => Yii::t('app', 'Fecha'),
            'exactitud' => Yii::t('app', 'Exactitud'),
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
