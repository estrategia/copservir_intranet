<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\AuthItem;

/**
 * AuthItemSearch represents the model behind the search form about `app\modules\intranet\models\AuthItem`.
 */
class AuthItemChildSearch extends AuthItemChild
{
    public $description;

    public function rules()
    {
        return [
            [['parent', 'child'], 'safe'],
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

      $query->joinWith('objChild');

      $query->andFilterWhere(['like', 'parent', $this->parent])
          ->andFilterWhere(['like', 'child', $this->child])
          ->andFilterWhere(['like', 'description', $this->description]);

      return $dataProvider;
    }
}
