<?php

namespace app\modules\api\models;

use Yii;

/**
 * This is the model class for table "ciudad".
 *
 * @property integer $id
 * @property string $ciudad
 *
 * @property Profile[] $profiles
 */
class Ciudad extends \yii\db\ActiveRecord
{
    
    const SCENARIO_CREATE='create';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ciudad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ciudad'], 'string', 'max' => 50],
        ];
    }

    
        public function scenarios(){
            $scenarios = parent::scenarios();
            $scenarios['create'] = ['id', 'ciudad'];
            return $scenarios;
        }
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ciudad' => 'Ciudad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['ciudad_id' => 'id']);
    }
}
