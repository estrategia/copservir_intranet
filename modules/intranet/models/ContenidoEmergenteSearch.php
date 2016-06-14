<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\ContenidoEmergente;

class ContenidoEmergenteSearch extends ContenidoEmergente
{
  public function rules()
  {
    return [
      [['idContenidoEmergente', 'estado'], 'integer'],
      [['contenido', 'fechaInicio', 'fechaFin', 'fechaRegistro'], 'safe'],
    ];
  }

  public function scenarios()
  {
    return Model::scenarios();
  }

  /**
  * Creates data provider instance with search query applied
  * @param array $params
  * @return ActiveDataProvider
  */
  public function search($params)
  {
    $query = ContenidoEmergente::find();

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      return $dataProvider;
    }

    $query->andFilterWhere([
      'idContenidoEmergente' => $this->idContenidoEmergente,
      'fechaInicio' => $this->fechaInicio,
      'fechaFin' => $this->fechaFin,
      'estado' => $this->estado,
      'fechaRegistro' => $this->fechaRegistro,
    ]);

    $query->andFilterWhere(['like', 'contenido', $this->contenido]);

    return $dataProvider;
  }
}
