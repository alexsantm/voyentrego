<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReporteProblema;

/**
 * ReporteProblemaSearch represents the model behind the search form about `app\models\ReporteProblema`.
 */
class ReporteProblemaSearch extends ReporteProblema
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'envio_id', 'user_id', 'problema_id'], 'integer'],
            [['fecha', 'imagen'], 'safe'],
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
        $query = ReporteProblema::find();

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
            'envio_id' => $this->envio_id,
            'user_id' => $this->user_id,
            'problema_id' => $this->problema_id,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'imagen', $this->imagen]);

        return $dataProvider;
    }
}
