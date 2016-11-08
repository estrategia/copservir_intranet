<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\InformacionVentas;

/**
 * AsignacionPuntoVentaSearch representa el modelo detrás de la forma de búsqueda de `app\modules\trademarketing\models\InformacionVentas`.
 */
 
class AsignacionPuntoVentaSearch extends InformacionVentas
{

    public function rules()
    {
        return [
            [['idAgrupacion', 'valor', 'mes'], 'integer'],
            [['idComercial', 'idAgrupacion', 'anio', 'valor', 'mes'], 'safe'],
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
        $query = InformacionVentas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idComercial' => $this->idComercial,
            'idAgrupacion' => $this->idAgrupacion,
            'anio' => $this->anio,
            'valor' => $this->valor,
            'mes' => $this->mes,
        ]);

        return $dataProvider;
    }

}
