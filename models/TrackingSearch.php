<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tracking;

/**
 * TrackingSearch represents the model behind the search form about `app\models\Tracking`.
 */
class TrackingSearch extends Tracking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['longitud', 'latitud', 'exactitud'], 'number'],
            [['fecha'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tracking::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'longitud' => $this->longitud,
            'latitud' => $this->latitud,
            'exactitud' => $this->exactitud,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha]);

        return $dataProvider;
    }
    
        public function searchmensajero($params)
    {
        $query = Tracking::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'longitud' => $this->longitud,
            'latitud' => $this->latitud,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha]);

        return $dataProvider;
    }
}
