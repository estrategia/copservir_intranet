<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\GrupoInteres;

/**
 * GrupoInteresSearch represents the model behind the search form about `app\modules\intranet\models\GrupoInteres`.
 */
class GrupointeresSearch extends GrupoInteres
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idGrupoInteres'], 'integer'],
            [['nombreGrupo'], 'safe'],
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
        $query = GrupoInteres::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idGrupoInteres' => $this->idGrupoInteres,
        ]);

        $query->andFilterWhere(['like', 'nombreGrupo', $this->nombreGrupo]);

        return $dataProvider;
    }
}
