<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Promocion;

/**
 * PromocionSearch represents the model behind the search form about `app\models\Promocion`.
 */
class PromocionSearch extends Promocion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'limite'], 'integer'],
            [['codigo_promocion', 'fecha_inicio', 'fecha_fin'], 'safe'],
            [['valor_promocion', 'valor_base'], 'number'],
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
        $query = Promocion::find();

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
            'valor_promocion' => $this->valor_promocion,
            'valor_base' => $this->valor_base,
            'limite' => $this->limite,
        ]);

        $query->andFilterWhere(['like', 'codigo_promocion', $this->codigo_promocion])
            ->andFilterWhere(['like', 'fecha_inicio', $this->fecha_inicio])
            ->andFilterWhere(['like', 'fecha_fin', $this->fecha_fin]);

        return $dataProvider;
    }
}
