<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\Indicadores;

/**
 * IndicadoresSearch represents the model behind the search form about `app\modules\intranet\models\Indicadores`.
 */
class IndicadoresSearch extends Indicadores
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idIndicador'], 'integer'],
            [['colorFondo', 'estado', 'descripcion', 'valor', 'textoComplementario'], 'safe'],
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
        $query = Indicadores::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idIndicador' => $this->idIndicador,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'colorFondo', $this->colorFondo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'valor', $this->valor])
            ->andFilterWhere(['like', 'textoComplementario', $this->textoComplementario]);

        return $dataProvider;
    }
}
