<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calificacion".
 *
 * @property integer $id
 * @property integer $calificacion
 * @property string $observacion
 * @property integer $mensajero_id
 * @property integer $user_id
 * @property integer $envio_id
 */
class Calificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calificacion', 'user_id', 'envio_id'], 'required'],
            [['calificacion', 'mensajero_id', 'user_id', 'envio_id'], 'integer'],
            [['observacion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'calificacion' => Yii::t('app', 'Calificacion'),
            'observacion' => Yii::t('app', 'Observacion'),
            'mensajero_id' => Yii::t('app', 'Mensajero ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'envio_id' => Yii::t('app', 'Envio ID'),
        ];
    }
}
