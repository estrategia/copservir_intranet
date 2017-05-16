<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\PublicacionesCampanas;

/**
 * PublicacionesCampanasSearch represents the model behind the search form about `app\modules\intranet\models\PublicacionesCampanas`.
 */
class PublicacionesCampanasSearch extends PublicacionesCampanas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idImagenCampana', 'numeroDocumento', 'estado', 'posicion'], 'integer'],
            [['nombreImagen', 'rutaImagen', 'urlEnlaceNoticia', 'fechaInicio', 'fechaFin'], 'safe'],
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
        $query = PublicacionesCampanas::find();

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
            'idImagenCampana' => $this->idImagenCampana,
            'numeroDocumento' => $this->numeroDocumento,
            'fechaInicio' => $this->fechaInicio,
            'estado' => $this->estado,
            'posicion' => $this->posicion,
            'fechaFin' => $this->fechaFin,
        ]);

        $query->andFilterWhere(['like', 'nombreImagen', $this->nombreImagen])
            ->andFilterWhere(['like', 'rutaImagen', $this->rutaImagen])
            ->andFilterWhere(['like', 'urlEnlaceNoticia', $this->urlEnlaceNoticia]);

        return $dataProvider;
    }
}
