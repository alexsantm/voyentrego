<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo_usuarios".
 *
 * @property integer $id
 * @property string $grupo
 * @property integer $responsable_user_id
 * @property string $fecha
 *
 * @property User $responsableUser
 * @property UserGrupo[] $userGrupos
 */
class GrupoUsuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupo_usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['responsable_user_id'], 'integer'],
            [['grupo', 'fecha'], 'string', 'max' => 45],
            [['responsable_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['responsable_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'grupo' => Yii::t('app', 'Grupo'),
            'responsable_user_id' => Yii::t('app', 'Responsable User ID'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsableUser()
    {
        return $this->hasOne(User::className(), ['id' => 'responsable_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGrupos()
    {
        return $this->hasMany(UserGrupo::className(), ['grupo_usuarios_id' => 'id']);
    }
}
