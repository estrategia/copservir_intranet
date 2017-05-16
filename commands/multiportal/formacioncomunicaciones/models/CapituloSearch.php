<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\Capitulo;

/**
 * CapituloSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\Capitulo`.
 */
class CapituloSearch extends Capitulo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCapitulo', 'estadoCapitulo'], 'integer'],
            [['nombreCapitulo', 'descripcionCapitulo', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
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
        $query = Capitulo::find();

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
            'idCapitulo' => $this->idCapitulo,
            'estadoCapitulo' => $this->estadoCapitulo,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
        ]);

        $query->andFilterWhere(['like', 'nombreCapitulo', $this->nombreCapitulo])
            ->andFilterWhere(['like', 'descripcionCapitulo', $this->descripcionCapitulo]);

        return $dataProvider;
    }
}
