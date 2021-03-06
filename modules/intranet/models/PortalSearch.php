<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\Portal;

/**
 * PortalSearch represents the model behind the search form about `app\modules\intranet\models\Portal`.
 */
class PortalSearch extends Portal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPortal', 'estado'], 'integer'],
            [['nombrePortal', 'colorPortal', 'logoPortal'], 'safe'],
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
        $query = Portal::find();

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
            'idPortal' => $this->idPortal,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'nombrePortal', $this->nombrePortal])
            ->andFilterWhere(['like', 'colorPortal', $this->colorPortal])
            ->andFilterWhere(['like', 'logoPortal', $this->logoPortal]);

        return $dataProvider;
    }
}
