<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos;

/**
 * ParametrosPuntosSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos`.
 */
class ParametrosPuntosSearch extends ParametrosPuntos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idParametroPunto', 'tipoParametro', 'valorPuntos', 'condicion', 'estado', 'valorPuntosExtra'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
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
        $query = ParametrosPuntos::find();

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
            'idParametroPunto' => $this->idParametroPunto,
            'tipoParametro' => $this->tipoParametro,
            'valorPuntos' => $this->valorPuntos,
            'condicion' => $this->condicion,
            'estado' => $this->estado,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
            'valorPuntosExtra' => $this->valorPuntosExtra,
        ]);

        return $dataProvider;
    }
}
