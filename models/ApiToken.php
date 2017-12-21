<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "api_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property string $fecha
 */
class ApiToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token', 'fecha'], 'required'],
            [['user_id'], 'integer'],
            [['token'], 'string', 'max' => 200],
            [['fecha'], 'string', 'max' => 10],
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
            'token' => Yii::t('app', 'Token'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }
    
    public function registrotoken($id_user, $tok)
    {
        $user_id = $id_user;
        $token = $tok;
        $fecha = date("Y-m-d H:i"); 
        $query = ApiToken::find()->where(['user_id'=>$user_id])->asArray()->count();
        if(empty($query)){
            $connection = Yii::$app->getDb();
             $command = $connection->createCommand('                                   
             INSERT INTO api_token (user_id, token, fecha)
             values ("'.$user_id.'", "'.$token.'", "'.$fecha.'")
             ');                   
             $resultado = $command->execute(); 
        }   
        else{
            \app\models\ApiToken::updateAll(['token' => $token, 'fecha'=>$fecha], 'user_id = '. "'".$user_id."'" );
        }
    }        
}
