<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contactanos_pagina".
 *
 * @property integer $id
 * @property string $texto
 */
class ContactanosPagina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contactanos_pagina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['texto'], 'required'],
            [['texto'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'texto' => Yii::t('app', 'Texto'),
        ];
    }
}
