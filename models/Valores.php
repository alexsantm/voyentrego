<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "valores".
 *
 * @property integer $id
 * @property string $km_inicio
 * @property string $km_fin
 * @property string $valor
 */
class Valores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'valores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['km_inicio', 'km_fin', 'valor'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'km_inicio' => Yii::t('app', 'Km Inicio'),
            'km_fin' => Yii::t('app', 'Km Fin'),
            'valor' => Yii::t('app', 'Valor'),
        ];
    }
}
