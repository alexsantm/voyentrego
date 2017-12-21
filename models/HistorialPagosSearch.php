<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistorialPagos;

/**
 * HistorialPagosSearch represents the model behind the search form about `app\models\HistorialPagos`.
 */
class HistorialPagosSearch extends HistorialPagos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mensajero_id'], 'integer'],
            [['valor'], 'number'],
            [['fecha', 'estado'], 'safe'],
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
        $query = HistorialPagos::find();

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
            'mensajero_id' => $this->mensajero_id,
            'valor' => $this->valor,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
    
    
    
        public function searchsemanal($params)
    {
        //$query = HistorialPagos::find();
                 $query = HistorialPagos::find()
                ->select(['h.id as id', 'h.mensajero_id as mensajero_id', 'h.valor as valor', 'h.fecha as fecha', 'h.estado as estado'])
                ->from('historial_pagos h, profile p')
                ->where('h.mensajero_id = p.user_id')
                ->andWhere('p.id_configuracion_pagos = 3')
                ->andWhere('h.estado = 2');
            
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
            'mensajero_id' => $this->mensajero_id,
            'valor' => $this->valor,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
    
    
        public function searchquincenal($params)
    {
//        $query = HistorialPagos::find();
//        $query = (new \yii\db\Query())
//        ->select(['h.id as id', 'h.mensajero_id as mensajero_id', 'h.valor as valor', 'h.fecha as fecha', 'h.estado as estado'])
//        ->from('historial_pagos h, profile p')
//        ->where('h.mensajero_id = p.user_id')
//        ->andWhere('p.id_configuracion_pagos = 2')
//        ->andWhere('h.estado = 2');
        
         $query = HistorialPagos::find()
                ->select(['h.id as id', 'h.mensajero_id as mensajero_id', 'h.valor as valor', 'h.fecha as fecha', 'h.estado as estado'])
                ->from('historial_pagos h, profile p')
                ->where('h.mensajero_id = p.user_id')
                ->andWhere('p.id_configuracion_pagos = 2')
                ->andWhere('h.estado = 2');

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
            'mensajero_id' => $this->mensajero_id,
            'valor' => $this->valor,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
    
        public function searchmensual($params)
    {
        //$query = HistorialPagos::find();
                 $query = HistorialPagos::find()
                ->select(['h.id as id', 'h.mensajero_id as mensajero_id', 'h.valor as valor', 'h.fecha as fecha', 'h.estado as estado'])
                ->from('historial_pagos h, profile p')
                ->where('h.mensajero_id = p.user_id')
                ->andWhere('p.id_configuracion_pagos = 1')
                ->andWhere('h.estado = 2');
        

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
            'mensajero_id' => $this->mensajero_id,
            'valor' => $this->valor,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
    
    
    
    
    
    
}
