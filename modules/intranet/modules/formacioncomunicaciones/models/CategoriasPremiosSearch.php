<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios;

/**
 * CategoriasPremiosSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios`.
 */
class CategoriasPremiosSearch extends CategoriasPremios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCategoria', 'orden', 'estado', 'idCategoriaPadre'], 'integer'],
            [['nombreCategoria', 'rutaIcono', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
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
        $query = CategoriasPremios::find();

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
            'idCategoria' => $this->idCategoria,
            'orden' => $this->orden,
            'estado' => $this->estado,
            'idCategoriaPadre' => $this->idCategoriaPadre,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
        ]);

        $query->andFilterWhere(['like', 'nombreCategoria', $this->nombreCategoria])
            ->andFilterWhere(['like', 'rutaIcono', $this->rutaIcono]);

        return $dataProvider;
    }
}
