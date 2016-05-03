<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\ContenidoEmergente;

/**
* ContenidoEmergenteSearch represents the model behind the search form about `app\modules\intranet\models\ContenidoEmergente`.
*/
class ContenidoEmergenteSearch extends ContenidoEmergente
{
  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['idContenidoEmergente', 'estado'], 'integer'],
      [['contenido', 'fechaInicio', 'fechaFin', 'fechaRegistro'], 'safe'],
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
    $query = ContenidoEmergente::find();

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
