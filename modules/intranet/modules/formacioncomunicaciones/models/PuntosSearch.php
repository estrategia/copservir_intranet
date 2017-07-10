<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\Puntos;

/**
 * PuntosSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\Puntos`.
 */
class PuntosSearch extends Puntos
{
    public $nombres;
    public $primerApellido;
    public $segundoApellido;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPunto', 'numeroDocumento', 'valorPuntos', 'idCuestionario', 'idParametroPunto', 'tipoParametro', 'condicion', 'idPuntoSincronizado', 'idCurso'], 'integer'],
            [['descripcionPunto', 'fechaCreacion', 'nombres', 'primerApellido', 'segundoApellido'], 'safe'],
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
        $query = Puntos::find();

        // add conditions that should always apply here
        $query->joinWith(['objUsuarioIntranet']);

        if (isset($params['misPuntos'])) {
            $query->andFilterWhere(['m_INTRA_Usuario.numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
        }

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
            'idPunto' => $this->idPunto,
            'numeroDocumento' => $this->numeroDocumento,
            'valorPuntos' => $this->valorPuntos,
            'idCuestionario' => $this->idCuestionario,
            'idParametroPunto' => $this->idParametroPunto,
            'tipoParametro' => $this->tipoParametro,
            'condicion' => $this->condicion,
            'fechaCreacion' => $this->fechaCreacion,
            'idPuntoSincronizado' => $this->idPuntoSincronizado,
            'idCurso' => $this->idCurso,
        ]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.nombres', $this->nombres]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.primerApellido', $this->primerApellido]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.segundoApellido', $this->segundoApellido]);
        $query->andFilterWhere(['like', 'descripcionPunto', $this->descripcionPunto]);

        return $dataProvider;
    }
}
