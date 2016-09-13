<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\Espacio;

/**
 * EspacioSearch representa el modelo detrás de la forma de búsqueda de `app\modules\trademarketing\models\Espacio`.
 */
class EspacioSearch extends Espacio
{
    public function rules()
    {
        return [
            [['idEspacio', 'estado'], 'integer'],
            [['nombre' ], 'safe'], //'idVariable'
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
        $query = Espacio::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith('variable');

        // grid filtering conditions
        $query->andFilterWhere([
            'idEspacio' => $this->idEspacio,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
              ->andFilterWhere(['like', 'm_TRMA_Variablemedicion.nombre', $this->idVariable]);

        return $dataProvider;
    }
}
