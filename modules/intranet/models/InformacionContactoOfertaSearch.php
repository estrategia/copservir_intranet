<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\InformacionContactoOferta;

class InformacionContactoOfertaSearch extends InformacionContactoOferta
{

  public function rules()
  {
    return [
      [['idInformacionContacto', 'estado', 'numeroDocumento'], 'integer'],
      [['plantillaContactoHtml', 'fechaRegistro'], 'safe'],
      [['nombrePlantilla'], 'string', 'max' => 45],
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
    $query = InformacionContactoOferta::find();

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      return $dataProvider;
    }

    $query->andFilterWhere([
      'idInformacionContacto' => $this->idInformacionContacto,
      'estado' => $this->estado,
      'fechaRegistro' => $this->fechaRegistro,
      'numeroDocumento' => $this->numeroDocumento,
    ]);

    $query->andFilterWhere(['like', 'plantillaContactoHtml', $this->plantillaContactoHtml]);

    return $dataProvider;
  }
}
