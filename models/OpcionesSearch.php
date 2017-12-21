<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Opciones;

/**
 * OpcionesSearch represents the model behind the search form about `app\models\Opciones`.
 */
class OpcionesSearch extends Opciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dia_pago_mensajeros', 'envios_tomados_por_dia'], 'integer'],
            [['radio'], 'number'],
            [['foto_promocion'], 'safe'],
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
        $query = Opciones::find();

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
            'radio' => $this->radio,
            'dia_pago_mensajeros' => $this->dia_pago_mensajeros,
            'envios_tomados_por_dia' => $this->envios_tomados_por_dia,
        ]);

        $query->andFilterWhere(['like', 'foto_promocion', $this->foto_promocion]);

        return $dataProvider;
    }
}
