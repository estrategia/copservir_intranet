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
    /**
     * @inheritdoc
     */
    public $description;

    public function rules()
    {
        return [
            [['parent', 'child'], 'safe'],
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
    public function searchPermisos($params){
      $query = AuthItemChild::find()
      ->where(['parent' => $params['id']]);

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

      $query->joinWith('objChild');

      $query->andFilterWhere(['like', 'parent', $this->parent])
          ->andFilterWhere(['like', 'child', $this->child])
          ->andFilterWhere(['like', 'description', $this->description]);


        //$query->joinWith('objCargo');

        //$query->andFilterWhere(['like', 'nombreCiudad', $this->idCiudad]);

      return $dataProvider;
    }
}
