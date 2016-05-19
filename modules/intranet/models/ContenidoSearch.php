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
            [['idContenido', 'numeroDocumentoPublicacion', 'estado', 'numeroDocumentoAprobacion', 'idLineaTiempo'], 'integer'],
            [['titulo', 'contenido', 'fechaPublicacion', 'fechaActualizacion', 'fechaAprobacion', 'fechaInicioPublicacion'], 'safe'],
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

      $query = self::find()->joinWith(['objContenidoPortal'])
      ->where('fechaInicioPublicacion<=:fecha AND estado=:estado and t_contenidoportal.idPortal=:idPortal')
      ->orderBy('fechaInicioPublicacion Desc')
      ->addParams([':estado' => self::APROBADO, ':fecha' => Date("Y-m-d H:i:s"), ':idPortal' => $portalModel->idPortal]);

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
            'pageSize' => 5,
          ],
      ]);



      var_dump( $this->fechaPublicacion);
      if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');

          return $dataProvider;
      }

      // grid filtering conditions
      $query->andFilterWhere([
          'idContenido' => $this->idContenido,
          'numeroDocumentoPublicacion' => $this->numeroDocumentoPublicacion,
          'fechaPublicacion' => $this->fechaPublicacion,
          'fechaActualizacion' => $this->fechaActualizacion,
          'estado' => $this->estado,
          'fechaAprobacion' => $this->fechaAprobacion,
          'numeroDocumentoAprobacion' => $this->numeroDocumentoAprobacion,
          'fechaInicioPublicacion' => $this->fechaInicioPublicacion,
          'idLineaTiempo' => $this->idLineaTiempo,
      ]);

      $query->andFilterWhere(['like', 'titulo', $this->titulo])
          ->andFilterWhere(['like', 'contenido', $this->contenido]);

      return $dataProvider;
    }
}
