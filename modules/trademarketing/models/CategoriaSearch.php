<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\Categoria;

/**
 * CategoriaSearch representa el modelo detrás de la forma de búsqueda de `app\modules\trademarketing\models\Categoria`.
 */
 
class CategoriaSearch extends Categoria
{
    public function rules()
    {
        return [
            [['idCategoria', 'estado'], 'integer'],
            [['nombre', 'descripcion'], 'safe'],
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
        $query = Categoria::find();

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
            'idCategoria' => $this->idCategoria,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
