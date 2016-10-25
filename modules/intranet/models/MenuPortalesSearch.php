<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\MenuPortales;

class MenuPortalesSearch extends MenuPortales
{
    public function rules()
    {
        return [
            [['idMenuPortales', 'idPortal', 'tipo', 'estado'], 'integer'],
            [['nombre', 'urlMenu', 'icono', 'fechaRegistro', 'fechaActualizacion'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MenuPortales::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idMenuPortales' => $this->idMenuPortales,
            'idPortal' => $this->idPortal,
            'tipo' => $this->tipo,
            'estado' => $this->estado,
            'fechaRegistro' => $this->fechaRegistro,
            'fechaActualizacion' => $this->fechaActualizacion,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'urlMenu', $this->urlMenu])
            ->andFilterWhere(['like', 'icono', $this->icono]);

        return $dataProvider;
    }
}
