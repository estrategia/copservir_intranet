<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\Documento;

class DocumentoSearch extends Documento
{
  public function rules()
  {
    return [
      [['idDocumento'], 'integer'],
      [['titulo', 'descripcion', 'rutaDocumento', 'estado', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
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
    $query = Documento::find();

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      return $dataProvider;
    }

    $query->andFilterWhere([
      'idDocumento' => $this->idDocumento,
      'fechaCreacion' => $this->fechaCreacion,
      'fechaActualizacion' => $this->fechaActualizacion,
    ]);

    $query->andFilterWhere(['like', 'titulo', $this->titulo])
    ->andFilterWhere(['like', 'descripcion', $this->descripcion])
    ->andFilterWhere(['like', 'rutaDocumento', $this->rutaDocumento])
    ->andFilterWhere(['like', 'estado', $this->estado]);

    return $dataProvider;
  }
}
