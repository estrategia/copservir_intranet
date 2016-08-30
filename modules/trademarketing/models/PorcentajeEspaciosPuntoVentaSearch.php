<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\PorcentajeEspaciosPuntoVenta;

/**
 * PorcentajeEspaciosPuntoVentaSearch representa el modelo detrás de la forma de búsqueda de
 * `app\modules\trademarketing\models\PorcentajeEspaciosPuntoVenta`.
 */
class PorcentajeEspaciosPuntoVentaSearch extends PorcentajeEspaciosPuntoVenta
{

    public function rules()
    {
        return [
            [['idPorcentajeEspacio', 'idEspacio', 'valor'], 'integer'],
            [['idComercial'], 'safe'],
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
        $query = PorcentajeEspaciosPuntoVenta::find();

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
            'idPorcentajeEspacio' => $this->idPorcentajeEspacio,
            'idEspacio' => $this->idEspacio,
            'valor' => $this->valor,
        ]);

        $query->andFilterWhere(['like', 'idComercial', $this->idComercial]);

        return $dataProvider;
    }
}
