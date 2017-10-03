<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recarga_transferencia".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fecha
 * @property string $doc_referencia
 * @property string $valor
 * @property integer $estado_id
 */
class RecargaTransferencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recarga_transferencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'fecha', 'doc_referencia', 'valor', 'estado_id'], 'required'],
            [['user_id', 'estado_id'], 'integer'],
            [['valor'], 'number'],
            [['fecha'], 'string', 'max' => 45],
            [['doc_referencia'], 'string', 'max' => 100],
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
            'fecha' => Yii::t('app', 'Fecha'),
            'doc_referencia' => Yii::t('app', 'Doc Referencia'),
            'valor' => Yii::t('app', 'Valor'),
            'estado_id' => Yii::t('app', 'Estado ID'),
        ];
    }
}
