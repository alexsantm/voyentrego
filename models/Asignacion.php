<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignacion".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $ruta_id
 * @property string $fecha
 *
 * @property Role $role
 * @property Ruta $ruta
 */
class Asignacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'ruta_id'], 'required'],
            [['role_id', 'ruta_id'], 'integer'],
            [['fecha'], 'string', 'max' => 45],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['ruta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ruta::className(), 'targetAttribute' => ['ruta_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role_id' => Yii::t('app', 'Role ID'),
            'ruta_id' => Yii::t('app', 'Ruta ID'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuta()
    {
        return $this->hasOne(Ruta::className(), ['id' => 'ruta_id']);
    }
}
