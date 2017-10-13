<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_grupo".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $grupo_usuarios_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $banned_at
 *
 * @property GrupoUsuarios $grupoUsuarios
 * @property User $user
 */
class UserGrupo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_grupo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'grupo_usuarios_id'], 'required'],
            [['user_id', 'grupo_usuarios_id'], 'integer'],
            [['created_at', 'updated_at', 'banned_at'], 'safe'],
            [['grupo_usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => GrupoUsuarios::className(), 'targetAttribute' => ['grupo_usuarios_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'grupo_usuarios_id' => Yii::t('app', 'Grupo Usuarios ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'banned_at' => Yii::t('app', 'Banned At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoUsuarios()
    {
        return $this->hasOne(GrupoUsuarios::className(), ['id' => 'grupo_usuarios_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
