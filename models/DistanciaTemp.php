<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distancia_temp".
 *
 * @property integer $id
 * @property integer $mensajero_id
 * @property string $km
 */
class DistanciaTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distancia_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mensajero_id'], 'integer'],
            [['km'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mensajero_id' => Yii::t('app', 'Mensajero ID'),
            'km' => Yii::t('app', 'Km'),
        ];
    }
}
