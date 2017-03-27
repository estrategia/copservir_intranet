<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\Contenido;

/**
 * ContenidoSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\Contenido`.
 */
class ContenidoSearch extends Contenido
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idContenido', 'estadoContenido', 'idAreaConocimiento', 'idModulo', 'idCapitulo', 'idTipoContenido', 'idContenidoCopia', 'frecuenciaMes'], 'integer'],
            [['contenido', 'fechaInicio', 'fechaFin', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
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
        $query = Contenido::find();

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
            'idContenido' => $this->idContenido,
            'estadoContenido' => $this->estadoContenido,
            'idAreaConocimiento' => $this->idAreaConocimiento,
            'idModulo' => $this->idModulo,
            'idCapitulo' => $this->idCapitulo,
            'idTipoContenido' => $this->idTipoContenido,
            'idContenidoCopia' => $this->idContenidoCopia,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'frecuenciaMes' => $this->frecuenciaMes,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
        ]);

        $query->andFilterWhere(['like', 'contenido', $this->contenido]);

        return $dataProvider;
    }
}
