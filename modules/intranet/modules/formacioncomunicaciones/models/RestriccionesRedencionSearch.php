<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencion;

/**
 * RestriccionesRedencionSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencion`.
 */
class RestriccionesRedencionSearch extends RestriccionesRedencion
{
    public $nombres;
    public $primerApellido;
    public $segundoApellido;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento'], 'integer'],
            [['nombres', 'primerApellido', 'segundoApellido'], 'string'],
            [['fechaCreacion'], 'safe'],
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
        $query = RestriccionesRedencion::find();

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
            'numeroDocumento' => $this->numeroDocumento,
            'fechaCreacion' => $this->fechaCreacion,
        ]);

        return $dataProvider;
    }
}
