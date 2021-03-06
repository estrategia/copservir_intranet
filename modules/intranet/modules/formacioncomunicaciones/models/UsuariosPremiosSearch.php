<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremios;

/**
 * UsuariosPremiosSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremios`.
 */
class UsuariosPremiosSearch extends UsuariosPremios
{
    public $nombrePremio;
    public $usuario;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUsuarioPremio', 'idPremio', 'numeroDocumento', 'cantidad', 'puntosRedimir', 'estado'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'nombrePremio', 'usuario'], 'safe'],
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
        $query = UsuariosPremios::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // $query->joinWith(['premio']);
            return $dataProvider;
        }

        if (isset($params['historial'])) {
            $query->andFilterWhere([
                't_FORCO_UsuariosPremios.estado' => UsuariosPremios::ESTADO_TRAMITADO,
                // 'like', 'm_INTRA_Usuario.nombres', $this->usuario
            ]);
            $query->orderBy(['fechaCreacion' => SORT_DESC]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'idUsuarioPremio' => $this->idUsuarioPremio,
            'idPremio' => $this->idPremio,
            'numeroDocumento' => $this->numeroDocumento,
            'cantidad' => $this->cantidad,
            'puntosRedimir' => $this->puntosRedimir,
            'estado' => $this->estado,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
        ]);

        if (isset($params['mis-redenciones'])) {
            $query->andFilterWhere([
                't_FORCO_UsuariosPremios.numeroDocumento' => Yii::$app->user->identity->numeroDocumento
            ]);
        }

        $query->joinWith(['objPremio' => function ($q) {
            $q->where('m_FORCO_Premio.nombrePremio LIKE "%' . $this->nombrePremio . '%"');
        }]);

        $query->joinWith(['objUsuarioIntranet' => function ($q) {
            $q->where('m_INTRA_Usuario.nombres LIKE "%' . $this->usuario . '%"');
        }]);

        return $dataProvider;
    }
}
