<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\ImagenesModuloGaleria;

/**
 * ImagenesModuloGaleriaSearch represents the model behind the search form about `app\modules\intranet\models\ImagenesModuloGaleria`.
 */
class ImagenesModuloGaleriaSearch extends ImagenesModuloGaleria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idImagenModuloGaleria', 'idModulo', 'orden'], 'integer'],
            [['nombreImagen', 'rutaImagen'], 'safe'],
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
    public function search($params, $idModulo)
    {
        $query = ImagenesModuloGaleria::find();

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
        $query->where(['idModulo' => $idModulo]);
        $query->andFilterWhere([
            'idImagenModuloGaleria' => $this->idImagenModuloGaleria,
            'idModulo' => $this->idModulo,
            'orden' => $this->orden,
        ]);

        $query->andFilterWhere(['like', 'nombreImagen', $this->nombreImagen])
            ->andFilterWhere(['like', 'rutaImagen', $this->rutaImagen]);

        return $dataProvider;
    }
}
