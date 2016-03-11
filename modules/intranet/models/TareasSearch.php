<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\Tareas;

/**
 * TareasSearch represents the model behind the search form about `app\modules\intranet\models\Tareas`.
 */
class TareasSearch extends Tareas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTarea', 'idUsuario', 'estadoTarea', 'prioridad'], 'integer'],
            [['titulo', 'descripcion', 'fechaRegistro', 'fechaEstimada'], 'safe'],
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
        $query = Tareas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idTarea' => $this->idTarea,
            'idUsuario' => $this->idUsuario,
            'fechaRegistro' => $this->fechaRegistro,
            'estadoTarea' => $this->estadoTarea,
            'fechaEstimada' => $this->fechaEstimada,
            'prioridad' => $this->prioridad,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
