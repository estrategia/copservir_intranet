<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoCalificacion;

/**
 * CapituloSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\Capitulo`.
 */
class ContenidoCalificacionSearch extends ContenidoCalificacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'idContenido', 'calificacion'], 'integer'],
            [['titulo', 'comentario', 'fecha'], 'safe'],
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
        $query = ContenidoCalificacion::find();

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

        if (isset($params['contenido'])) {
            $query->andFilterWhere([
                'idContenido' => $params['contenido'],
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'numeroDocumento' => $this->numeroDocumento,
            'idContenido' => $this->idContenido,
            'fecha' => $this->fecha,
            'calificacion' => $this->calificacion,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'comentario', $this->comentario]);

        return $dataProvider;
    }
}
