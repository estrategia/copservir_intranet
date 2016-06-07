<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\MenuPortales;

/**
 * MenuPortalesSearch represents the model behind the search form about `app\modules\intranet\models\MenuPortales`.
 */
class MenuPortalesSearch extends MenuPortales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idMenuPortales', 'idPortal', 'tipo', 'estado'], 'integer'],
            [['nombre', 'urlMenu', 'icono', 'fechaInicio', 'fechaFin', 'fechaRegistro', 'fechaActualizacion'], 'safe'],
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
        $query = MenuPortales::find();

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
            'idMenuPortales' => $this->idMenuPortales,
            'idPortal' => $this->idPortal,
            'tipo' => $this->tipo,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
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
