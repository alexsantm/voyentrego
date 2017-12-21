<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planes_recarga".
 *
 * @property integer $id
 * @property string $valor
 * @property string $valor_promo
 */
class PlanesRecarga extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planes_recarga';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor', 'valor_promo'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'valor' => Yii::t('app', 'Valor'),
            'valor_promo' => Yii::t('app', 'Valor Promo'),
        ];
    }
}
