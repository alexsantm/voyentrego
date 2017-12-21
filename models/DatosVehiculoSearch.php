<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DatosVehiculo;

/**
 * DatosVehiculoSearch represents the model behind the search form about `app\models\DatosVehiculo`.
 */
class DatosVehiculoSearch extends DatosVehiculo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'anio', 'responsable_user_id', 'estado_id'], 'integer'],
            [['marca', 'modelo', 'placa', 'fecha'], 'safe'],
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
        $query = DatosVehiculo::find();

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
            'anio' => $this->anio,
            'responsable_user_id' => $this->responsable_user_id,
            'estado_id' => $this->estado_id,
        ]);

        $query->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'placa', $this->placa])
            ->andFilterWhere(['like', 'fecha', $this->fecha]);

        return $dataProvider;
    }
    
       public function searchsuperadmin($params)
    {
        $query = DatosVehiculo::find()->where(['user_id'=>NULL]);

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
            'anio' => $this->anio,
            'responsable_user_id' => $this->responsable_user_id,
            'estado_id' => $this->estado_id,
        ]);

        $query->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'placa', $this->placa])
            ->andFilterWhere(['like', 'fecha', $this->fecha]);

        return $dataProvider;
    }
}
