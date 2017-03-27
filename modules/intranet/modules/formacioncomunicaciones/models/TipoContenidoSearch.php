<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenido;

/**
 * TipoContenidoSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenido`.
 */
class TipoContenidoSearch extends TipoContenido
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTipoContenido', 'estadoTipoContenido'], 'integer'],
            [['nombreTipoContenido', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
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
        $query = TipoContenido::find();

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
            'idTipoContenido' => $this->idTipoContenido,
            'estadoTipoContenido' => $this->estadoTipoContenido,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
        ]);

        $query->andFilterWhere(['like', 'nombreTipoContenido', $this->nombreTipoContenido]);

        return $dataProvider;
    }
}
