<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\LineaTiempo;

class LineaTiempoSearch extends LineaTiempo
{

    public function rules()
    {
        return [
            [['idLineaTiempo', 'estado', 'autorizacionAutomatica', 'tipo', 'solicitarGrupoObjetivo', 'orden'], 'integer'],
            [['nombreLineaTiempo', 'fechaInicio', 'fechaFin', 'color', 'icono', 'descripcion'], 'safe'],
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
        $query = LineaTiempo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

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
