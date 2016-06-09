<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\EventosCalendario;

/**
* DocumentoSearch represents the model behind the search form about `app\modules\intranet\models\Documento`.
*/
class EventosCalendarioSearch extends EventosCalendario
{
  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['idContenido', 'numeroDocumento', 'estado'], 'integer'],
      [['tituloEvento', 'descripcionEvento', 'numeroDocumento', 'fechaRegistro', 'horaInicioEvento', 'fechaInicioEvento', 'fechaFinEvento', 'fechaInicioVisible', 'fechaFinVisible'], 'safe'],
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
    $query = EventosCalendario::find();

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
      'estado' => $this->estado,
      'fechaRegistro' => $this->fechaRegistro,
      'fechaInicioEvento' => $this->fechaInicioEvento,
      'fechaFinEvento' => $this->fechaFinEvento,
      'fechaInicioVisible' => $this->fechaInicioVisible,
      'fechaInicioVisible' => $this->fechaInicioVisible,
      'fechaFinVisible' => $this->fechaFinVisible,
    ]);

    $query->andFilterWhere(['like', 'tituloEvento', $this->tituloEvento])
    ->andFilterWhere(['like', 'descripcionEvento', $this->descripcionEvento])
    ;

    return $dataProvider;
  }
}
