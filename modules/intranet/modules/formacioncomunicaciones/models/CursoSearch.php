<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\Curso;

/**
 * CursoSearch represents the model behind the search form about `app\modules\intranet\modules\formacioncomunicaciones\models\Curso`.
 */
class CursoSearch extends Curso
{
    public $tipoCurso;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCurso', 'estadoCurso'], 'integer'],
            [['nombreCurso', 'presentacionCurso', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
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
        $query = Curso::find();

        // add conditions that should always apply here

        if (isset($params['gruposInteresUsuario'])) {
            $query->leftJoin('t_FORCO_CursoGruposInteres', 't_FORCO_CursoGruposInteres.idCurso = m_FORCO_Curso.idCurso');
            $query->andFilterWhere(['in', 't_FORCO_CursoGruposInteres.idGrupoInteres', array_values($params['gruposInteresUsuario'])]);
        }

        if (isset($params['terminados'])) {
            $query->leftJoin('t_FORCO_CursosUsuario', 't_FORCO_CursosUsuario.idCurso = m_FORCO_Curso.idCurso');
            $query->andFilterwhere(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
        }

        if (isset($params['activos'])) {
            $query->andFilterWhere(['estadoCurso' => Curso::ESTADO_ACTIVO]);
            $query->andFilterWhere(['<=', 'fechaInicio', date("Y-m-d H:i:s")]);
        }

        if (isset($params['vigentes'])) {
            $query->andFilterWhere(['>=', 'fechaFin', date("Y-m-d H:i:s")]);
        }

        if (isset($params['recomendados'])) {
            $query->orderBy(['cantidadPuntos' => SORT_DESC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'sort'=> ['defaultOrder' => ['fechaActivacion'=>SORT_DESC]],
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);

        if (isset($params['limite'])) {
            $query->limit($params['limite']);
        }
        //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idCurso' => $this->idCurso,
            'estadoCurso' => $this->estadoCurso,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
            'tipoCurso' => $this->tipoCurso
        ]);

        $query->andFilterWhere(['like', 'nombreCurso', $this->nombreCurso])
            ->andFilterWhere(['like', 'presentacionCurso', $this->presentacionCurso]);

        return $dataProvider;
    }
}
