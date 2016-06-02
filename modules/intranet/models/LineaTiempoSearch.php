<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\LineaTiempo;

/**
 * LineaTiempoSearch represents the model behind the search form about `app\modules\intranet\models\LineaTiempo`.
 */
class LineaTiempoSearch extends LineaTiempo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idLineaTiempo', 'estado', 'autorizacionAutomatica', 'tipo', 'solicitarGrupoObjetivo', 'orden'], 'integer'],
            [['nombreLineaTiempo', 'fechaInicio', 'fechaFin', 'color', 'icono', 'descripcion'], 'safe'],
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
        $query = LineaTiempo::find();

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
            'idLineaTiempo' => $this->idLineaTiempo,
            'estado' => $this->estado,
            'autorizacionAutomatica' => $this->autorizacionAutomatica,
            'tipo' => $this->tipo,
            'solicitarGrupoObjetivo' => $this->solicitarGrupoObjetivo,
            'orden' => $this->orden,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);

        $query->andFilterWhere(['like', 'nombreLineaTiempo', $this->nombreLineaTiempo])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'icono', $this->icono])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
