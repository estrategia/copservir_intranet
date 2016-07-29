<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\AuthItem;

/**
 * AuthItemSearch represents the model behind the search form about `app\modules\intranet\models\AuthItem`.
 */
class AuthItemSearch extends AuthItem
{
    public function rules()
    {
        return [
            [['name', 'title', 'url', 'description', 'rule_name', 'data'], 'safe'],
            [['type', 'created_at', 'updated_at'], 'integer'],
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
        $query = AuthItem::find()->where(['type'=> 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'rule_name', $this->rule_name])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }

    public function searchPermisos($params){
      $query = AuthItemChild::find()
      ->where(['parent' => $params['id']]);

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);

      $this->load($params);

      if (!$this->validate()) {
          return $dataProvider;
      }
      
      $query->andFilterWhere([
          'type' => $this->type,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
      ]);

      $query->andFilterWhere(['like', 'name', $this->name])
          ->andFilterWhere(['like', 'title', $this->title])
          ->andFilterWhere(['like', 'url', $this->url])
          ->andFilterWhere(['like', 'description', $this->description])
          ->andFilterWhere(['like', 'rule_name', $this->rule_name])
          ->andFilterWhere(['like', 'data', $this->data]);

      return $dataProvider;
    }
}
