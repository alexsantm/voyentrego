<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Envio;

/**
 * EnvioSearch represents the model behind the search form about `app\models\Envio`.
 */
class EnvioSearch extends Envio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ciudad_id', 'user_id', 'estado_envio_id', 'tipo_envio_id', 'dimensiones_id', 'mensajero_id'], 'integer'],
            [['remitente', 'direccion_origen', 'celular', 'fecha_registro', 'fecha_fin_envio', 'observacion'], 'safe'],
            [['latitud', 'longitud', 'total_km', 'valor_total'], 'number'],
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
        $query = Envio::find();

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
            'ciudad_id' => $this->ciudad_id,
            'user_id' => $this->user_id,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'total_km' => $this->total_km,
            'valor_total' => $this->valor_total,
            'estado_envio_id' => $this->estado_envio_id,
            'tipo_envio_id' => $this->tipo_envio_id,
            'dimensiones_id' => $this->dimensiones_id,
            'mensajero_id' => $this->mensajero_id,
        ]);

        $query->andFilterWhere(['like', 'remitente', $this->remitente])
            ->andFilterWhere(['like', 'direccion_origen', $this->direccion_origen])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'fecha_registro', $this->fecha_registro])
            ->andFilterWhere(['like', 'fecha_fin_envio', $this->fecha_fin_envio])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);
        $dataProvider->pagination->pageSize=10;
        return $dataProvider;
    }
    
    
//     public function searchindex($params)
//    {
//        $user_id = Yii::$app->user->identity;
//        $query = Envio::find()->where(['user_id'=>$user_id]);
//
//        // add conditions that should always apply here
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'ciudad_id' => $this->ciudad_id,
//            'user_id' => $this->user_id,
//            'latitud' => $this->latitud,
//            'longitud' => $this->longitud,
//            'total_km' => $this->total_km,
//            'valor_total' => $this->valor_total,
//            'estado_envio_id' => $this->estado_envio_id,
//            'tipo_envio_id' => $this->tipo_envio_id,
//            'dimensiones_id' => $this->dimensiones_id,
//            'mensajero_id' => $this->mensajero_id,
//        ]);
//
//        $query->andFilterWhere(['like', 'remitente', $this->remitente])
//            ->andFilterWhere(['like', 'direccion_origen', $this->direccion_origen])
//            ->andFilterWhere(['like', 'celular', $this->celular])
//            ->andFilterWhere(['like', 'fecha_registro', $this->fecha_registro])
//            ->andFilterWhere(['like', 'fecha_fin_envio', $this->fecha_fin_envio])
//            ->andFilterWhere(['like', 'observacion', $this->observacion]);
//
//        return $dataProvider;
//    }
}
