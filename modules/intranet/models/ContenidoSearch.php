<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\Contenido;

/**
 * ContenidoSearch represents the model behind the search form about `app\modules\intranet\models\Contenido`.
 */
class ContenidoSearch extends Contenido
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idContenido', 'numeroDocumentoPublicacion', 'estado', 'numeroDocumentoAprobacion'], 'integer'],
            [['titulo', 'idLineaTiempo', 'contenido', 'fechaPublicacion', 'fechaActualizacion', 'fechaAprobacion', 'fechaInicioPublicacion'], 'safe'],
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
    public function searchNoticiasPortal($params, $nombrePortal)
    {
      $this->load($params);

      $portalModel = Portal::encontrarModeloPorNombre($nombrePortal);

      $query = self::find()->joinWith(['objContenidoPortal'])->with('objLineaTiempo')
      ->where('t_Contenido.estado=:estado and t_ContenidoPortal.idPortal=:idPortal')//->where('fechaInicioPublicacion<=:fecha AND estado=:estado and t_ContenidoPortal.idPortal=:idPortal')
      ->orderBy('fechaInicioPublicacion Desc')
      ->addParams([':estado' => self::APROBADO,  ':idPortal' => $portalModel->idPortal]); //':fecha' => Date("Y-m-d"),

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
            'pageSize' => 5,
          ],
      ]);

      if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');

          return $dataProvider;
      }

      if (!is_null($this->fechaInicioPublicacion)) {


        $query->andFilterWhere([
            '>=',  'fechaInicioPublicacion', Date("Y-m-d H:i:s", strtotime($this->fechaInicioPublicacion.' 00:00:00')),
        ]);

        $query->andFilterWhere([
            '<=',  'fechaInicioPublicacion', Date("Y-m-d H:i:s", strtotime($this->fechaInicioPublicacion.' 23:59:59')),
        ]);
      }


      $query->andFilterWhere(['like', 'titulo', $this->titulo]);
      $query->joinWith('objLineaTiempo');
      $query->andFilterWhere(['like', 'nombreLineaTiempo', $this->idLineaTiempo]);


      return $dataProvider;
    }

}
