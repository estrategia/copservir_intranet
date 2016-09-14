<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\VariableMedicion;

/**
 * VariableMedicionSearch representa el modelo detrás de la forma de búsqueda de `app\modules\trademarketing\models\VariableMedicion`.
 */
 
class VariableMedicionSearch extends VariableMedicion
{

    public function rules()
    {
        return [
            [['idVariable', 'estado', 'calificaUnidadNegocio'], 'integer'],
            [['nombre', 'descripcion', 'idCategoria'], 'safe'],
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
        $query = VariableMedicion::find();

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
            'idVariable' => $this->idVariable,
            'estado' => $this->estado,
            'calificaUnidadNegocio' => $this->calificaUnidadNegocio,
        ]);

        $query->joinWith('categoria');

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'm_TRMA_Categoria.nombre', $this->idCategoria])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);


        return $dataProvider;
    }
}
