<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Destino;

/**
 * DestinoSearch represents the model behind the search form about `app\models\Destino`.
 */
class DestinoSearch extends Destino
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ciudad_id', 'envio_id', 'estado_envio_id', 'retorno_destino_id', 'retorno_inicio', 'tipo_envio_id', 'dimensiones_id'], 'integer'],
            [['destinatario', 'direccion_destino', 'celular', 'fecha_registro', 'fecha_asignacion', 'fecha_finalizacion', 'observacion'], 'safe'],
            [['latitud', 'longitud', 'kilometros', 'valor'], 'number'],
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
        $query = Destino::find();

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
            'envio_id' => $this->envio_id,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'kilometros' => $this->kilometros,
            'valor' => $this->valor,
            'estado_envio_id' => $this->estado_envio_id,
            'retorno_destino_id' => $this->retorno_destino_id,
            'retorno_inicio' => $this->retorno_inicio,
            'tipo_envio_id' => $this->tipo_envio_id,
            'dimensiones_id' => $this->dimensiones_id,
        ]);

        $query->andFilterWhere(['like', 'destinatario', $this->destinatario])
            ->andFilterWhere(['like', 'direccion_destino', $this->direccion_destino])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'fecha_registro', $this->fecha_registro])
            ->andFilterWhere(['like', 'fecha_asignacion', $this->fecha_asignacion])
            ->andFilterWhere(['like', 'fecha_finalizacion', $this->fecha_finalizacion])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
    /*************************************************************************************/
    
       public function searchdestinos($params)
    {
        $query = Destino::find();

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
            'envio_id' => $this->envio_id,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'kilometros' => $this->kilometros,
            'valor' => $this->valor,
            'estado_envio_id' => $this->estado_envio_id,
            'retorno_destino_id' => $this->retorno_destino_id,
            'retorno_inicio' => $this->retorno_inicio,
            'tipo_envio_id' => $this->tipo_envio_id,
            'dimensiones_id' => $this->dimensiones_id,
        ]);

        $query->andFilterWhere(['like', 'direccion_destino', $this->direccion_destino]);

        return $dataProvider;
    }
    
}
