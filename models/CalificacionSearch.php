<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calificacion;

/**
 * CalificacionSearch represents the model behind the search form about `app\models\Calificacion`.
 */
class CalificacionSearch extends Calificacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'calificacion', 'mensajero_id', 'user_id', 'envio_id'], 'integer'],
            [['observacion'], 'safe'],
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
        $query = Calificacion::find();

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
            'calificacion' => $this->calificacion,
            'mensajero_id' => $this->mensajero_id,
            'user_id' => $this->user_id,
            'envio_id' => $this->envio_id,
        ]);

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
