<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\CursosUsuario;

/**
 * CursosUsuarioSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\CursosUsuario`.
 */
class CursosUsuarioSearch extends CursosUsuario
{
    public $nombreCurso;
    public $nombres;
    public $primerApellido;
    public $segundoApellido;
    public $nombreProveedor;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCurso', 'numeroDocumento'], 'integer'],
            [['fechaCreacion', 'fechaInicioLectura', 'nombreCurso', 'nombres', 'primerApellido', 'segundoApellido', 'nombreProveedor'], 'safe'],
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
        $query = CursosUsuario::find();

        $query->joinWith(['curso']);
        $query->joinWith(['usuarioIntranet']);

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
            'idCurso' => $this->idCurso,
            'numeroDocumento' => $this->numeroDocumento,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaInicioLectura' => $this->fechaInicioLectura,
        ]);

        $query->andFilterWhere(['like', 'm_FORCO_Curso.nombreCurso', $this->nombreCurso]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.nombres', $this->nombres]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.primerApellido', $this->primerApellido]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.segundoApellido', $this->segundoApellido]);

        return $dataProvider;
    }
}
