<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\EventosCalendario;

class EventosCalendarioSearch extends EventosCalendario
{
  public function rules()
  {
    return [
      [[ 'numeroDocumento', 'estado'], 'integer'],
      [['tituloEvento', 'numeroDocumento', 'fechaRegistro', 'horaInicioEvento', 'fechaInicioEvento', 'fechaFinEvento', 'fechaInicioVisible'], 'safe'],
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
    $query = EventosCalendario::find()->orderBy('fechaRegistro DESC');

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      return $dataProvider;
    }

    $query->andFilterWhere([
      'estado' => $this->estado,
      'fechaRegistro' => $this->fechaRegistro,
      'fechaInicioEvento' => $this->fechaInicioEvento,
      'fechaFinEvento' => $this->fechaFinEvento,
      'fechaInicioVisible' => $this->fechaInicioVisible,
      'fechaInicioVisible' => $this->fechaInicioVisible,
      //'fechaFinVisible' => $this->fechaFinVisible,
    ]);

    $query->andFilterWhere(['like', 'tituloEvento', $this->tituloEvento])

    ;

    return $dataProvider;
  }
}
