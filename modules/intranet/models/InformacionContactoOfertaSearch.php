<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\InformacionContactoOferta;

/**
 * InformacionContactoOfertaSearch represents the model behind the search form about `app\modules\intranet\models\InformacionContactoOferta`.
 */
class InformacionContactoOfertaSearch extends InformacionContactoOferta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idInformacionContacto', 'estado', 'numeroDocumento'], 'integer'],
            [['plantillaContactoHtml', 'fechaRegistro'], 'safe'],
            [['nombrePlantilla'], 'string', 'max' => 45],
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
        $query = InformacionContactoOferta::find();

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
            'idInformacionContacto' => $this->idInformacionContacto,
            'estado' => $this->estado,
            'fechaRegistro' => $this->fechaRegistro,
            'numeroDocumento' => $this->numeroDocumento,
        ]);

        $query->andFilterWhere(['like', 'plantillaContactoHtml', $this->plantillaContactoHtml]);

        return $dataProvider;
    }
}
