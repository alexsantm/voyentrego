<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarjeta_credito".
 *
 * @property integer $id
 * @property string $creditCard_number
 * @property string $creditCard_expirationDate
 * @property string $creditCard_cvv
 * @property string $amount
 */
class TarjetaCredito extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tarjeta_credito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['creditCard_number'], 'string', 'max' => 16],
            [['creditCard_expirationDate'], 'string', 'max' => 4],
            [['creditCard_cvv'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'creditCard_number' => Yii::t('app', 'Credit Card Number'),
            'creditCard_expirationDate' => Yii::t('app', 'Credit Card Expiration Date'),
            'creditCard_cvv' => Yii::t('app', 'Credit Card Cvv'),
            'amount' => Yii::t('app', 'Amount'),
        ];
    }
}
