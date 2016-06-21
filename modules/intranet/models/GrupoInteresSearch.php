<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\GrupoInteres;

class GrupointeresSearch extends GrupoInteres
{
  public function rules()
  {
    return [
      [['idGrupoInteres'], 'integer'],
      [['nombreGrupo', 'estado'], 'safe'],
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
    $query = GrupoInteres::find();

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      return $dataProvider;
    }

    $query->andFilterWhere([
      'idGrupoInteres' => $this->idGrupoInteres,
      'estado' => $this->estado,
    ]);

    $query->andFilterWhere(['like', 'nombreGrupo', $this->nombreGrupo]);

    return $dataProvider;
  }
}
