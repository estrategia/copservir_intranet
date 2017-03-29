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
            [['idContenido', 'estadoContenido', 'idCapitulo', 'idContenidoCopia', 'frecuenciaMes'], 'integer'],
            [['contenido', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
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
        // if (isset($params['gruposInteresUsuario'])) {
        //     $query->leftJoin('t_FORCO_ContenidoGruposInteres', 't_FORCO_ContenidoGruposInteres.idContenido = m_FORCO_Contenido.idContenido');
        //     $query->andFilterWhere(['in', 't_FORCO_ContenidoGruposInteres.idGrupoInteres', array_values($params['gruposInteresUsuario'])]);
        // }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // \yii\helpers\VarDumper::dump($params, 10, true);
        // grid filtering conditions
        $query->andFilterWhere([
            'idContenido' => $this->idContenido,
            'estadoContenido' => $this->estadoContenido,
            'idCapitulo' => $this->idCapitulo,
            'idContenidoCopia' => $this->idContenidoCopia,
            'frecuenciaMes' => $this->frecuenciaMes,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
        ]);

        $query->andFilterWhere(['like', 'contenido', $this->contenido]);
        // var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        return $dataProvider;
    }
}
