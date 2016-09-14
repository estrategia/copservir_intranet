<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\CriteriosEvaluacionVentas;

/**
 * CriteriosEvaluacionVentasSearch representa el modelo detrás de la forma de búsqueda de
 *   `app\modules\trademarketing\models\CriteriosEvaluacionVentas`.
 */
 
class CriteriosEvaluacionVentasSearch extends CriteriosEvaluacionVentas
{
    public function rules()
    {
        return [
            [['idCriterio', 'valor', 'estado'], 'integer'],
            [['descripcion'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Crea una instancia dataProvider con la query para aplicar la busqueda.
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CriteriosEvaluacionVentas::find();

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
            'idCriterio' => $this->idCriterio,
            'valor' => $this->valor,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
