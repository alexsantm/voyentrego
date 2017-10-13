<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TarjetaCredito;

/**
 * TarjetaCreditoSearch represents the model behind the search form about `app\models\TarjetaCredito`.
 */
class TarjetaCreditoSearch extends TarjetaCredito
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['creditCard_number', 'creditCard_expirationDate', 'creditCard_cvv'], 'safe'],
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
        $query = TarjetaCredito::find();

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
        ]);

        $query->andFilterWhere(['like', 'creditCard_number', $this->creditCard_number])
            ->andFilterWhere(['like', 'creditCard_expirationDate', $this->creditCard_expirationDate])
            ->andFilterWhere(['like', 'creditCard_cvv', $this->creditCard_cvv]);

        return $dataProvider;
    }
}
