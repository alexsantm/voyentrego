<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status_mensajero".
 *
 * @property integer $id
 * @property string $status
 * @property string $color
 * @property string $icono
 */
class StatusMensajero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_mensajero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'color'], 'required'],
            [['status', 'icono'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'color' => Yii::t('app', 'Color'),
            'icono' => Yii::t('app', 'Icono'),
        ];
    }
}
