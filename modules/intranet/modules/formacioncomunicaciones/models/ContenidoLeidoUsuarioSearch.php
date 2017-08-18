<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoLeidoUsuario;

/**
 * ContenidoLeidoUsuarioSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoLeidoUsuario`.
 */
class ContenidoLeidoUsuarioSearch extends ContenidoLeidoUsuario
{   
    public $tituloContenido;
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
            [['numeroDocumento', 'idContenido', 'idCurso', 'tiempoLectura'], 'integer'],
            [['fechaCreacion', 'tituloContenido', 'nombreCurso', 'nombres', 'primerApellido', 'segundoApellido', 'nombreProveedor'], 'safe'],
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
        $query = ContenidoLeidoUsuario::find();

        $query->joinWith(['contenido']);
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
            't_FORCO_ContenidoLeidoUsuario.numeroDocumento' => $this->numeroDocumento,
            'idContenido' => $this->idContenido,
            'fechaCreacion' => $this->fechaCreacion,
            'idCurso' => $this->idCurso,
            'tiempoLectura' => $this->tiempoLectura,
        ]);

        $query->andFilterWhere(['like', 'm_FORCO_Contenido.tituloContenido', $this->tituloContenido]);
        $query->andFilterWhere(['like', 'm_FORCO_Contenido.nombreProveedor', $this->nombreProveedor]);
        $query->andFilterWhere(['like', 'm_FORCO_Curso.nombreCurso', $this->nombreCurso]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.nombres', $this->nombres]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.primerApellido', $this->primerApellido]);
        $query->andFilterWhere(['like', 'm_INTRA_Usuario.segundoApellido', $this->segundoApellido]);

        return $dataProvider;
    }
}
