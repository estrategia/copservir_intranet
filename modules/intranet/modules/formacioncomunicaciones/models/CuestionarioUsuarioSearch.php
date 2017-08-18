<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\CuestionarioUsuario;

/**
 * CuestionarioUsuarioSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\CuestionarioUsuario`.
 */
class CuestionarioUsuarioSearch extends CuestionarioUsuario
{
    public $tipoCuestionario;
    public $nombreCuestionario;
    public $tituloCurso;
    public $porcentajeNecesario;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCuestionarioUsuario', 'idCuestionario', 'numeroDocumento', 'estadoCuestionario'], 'integer'],
            [['numeroPreguntasTotal', 'numeroPreguntasRespondidas', 'porcentajeObtenido'], 'number'],
            [['fechaCreacion', 'fechaActualizacion', 'tipoCuestionario', 'nombreCuestionario' ,'tituloCurso', 'porcentajeNecesario'], 'safe'],
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
        $query = CuestionarioUsuario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15
            ]
        ]);

        if (isset($params['aprobados'])) {
            $query->joinWith('objCuestionario')
                ->where([
                    '>=', 
                    't_FORCO_CuestionarioUsuario.porcentajeObtenido',
                    'm_FORCO_Cuestionario.porcentajeMinimo'
                ])
                ->andWhere([
                    '<>', 't_FORCO_CuestionarioUsuario.porcentajeObtenido', 0
                ])
                ->andWhere([
                    't_FORCO_CuestionarioUsuario.estadoCuestionario' => Cuestionario::CUESTIONARIO_CERRADO
                ]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idCuestionarioUsuario' => $this->idCuestionarioUsuario,
            'idCuestionario' => $this->idCuestionario,
            'numeroDocumento' => $this->numeroDocumento,
            'numeroPreguntasTotal' => $this->numeroPreguntasTotal,
            'numeroPreguntasRespondidas' => $this->numeroPreguntasRespondidas,
            'porcentajeObtenido' => $this->porcentajeObtenido,
            'estadoCuestionario' => $this->estadoCuestionario,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
        ]);

        return $dataProvider;
    }
}
