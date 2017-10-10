<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Descuento;

/**
 * DescuentoSearch represents the model behind the search form about `app\models\Descuento`.
 */
class DescuentoSearch extends Descuento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codigo_descuento', 'fecha_inicio', 'fecha_fin', 'archivo_promocion'], 'safe'],
            [['valor_descuento'], 'number'],
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
        $query = Descuento::find();

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
            'valor_descuento' => $this->valor_descuento,
        ]);

        $query->andFilterWhere(['like', 'codigo_descuento', $this->codigo_descuento])
            ->andFilterWhere(['like', 'fecha_inicio', $this->fecha_inicio])
            ->andFilterWhere(['like', 'fecha_fin', $this->fecha_fin])
            ->andFilterWhere(['like', 'archivo_promocion', $this->archivo_promocion]);

        return $dataProvider;
    }
}
