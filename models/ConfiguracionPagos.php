<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configuracion_pagos".
 *
 * @property integer $id
 * @property integer $numero_pagos_mes
 * @property integer $porcentaje
 */
class ConfiguracionPagos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuracion_pagos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero_pagos_mes', 'porcentaje'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero_pagos_mes' => Yii::t('app', 'Numero Pagos Mes'),
            'porcentaje' => Yii::t('app', 'Porcentaje'),
        ];
    }
}
