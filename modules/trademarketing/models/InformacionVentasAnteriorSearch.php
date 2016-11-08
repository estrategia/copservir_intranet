<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\InformacionVentasAnterior;

/**
 * InformacionVentasAnteriorSearch represents the model behind the search form about `app\modules\trademarketing\models\InformacionVentasAnterior`.
 */
class InformacionVentasAnteriorSearch extends InformacionVentasAnterior
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idInformacionVentasAnterior', 'idAgrupacion', 'mes', 'valor'], 'integer'],
            [['idComercial'], 'safe'],
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
        $query = InformacionVentasAnterior::find();

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
            'idInformacionVentasAnterior' => $this->idInformacionVentasAnterior,
            'idAgrupacion' => $this->idAgrupacion,
            'mes' => $this->mes,
            'valor' => $this->valor,
        ]);

        $query->andFilterWhere(['like', 'idComercial', $this->idComercial]);

        return $dataProvider;
    }
}
