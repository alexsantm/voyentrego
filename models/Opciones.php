<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "opciones".
 *
 * @property integer $id
 * @property string $radio
 */
class Opciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'opciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['radio'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'radio' => Yii::t('app', 'Radio'),
        ];
    }
}
