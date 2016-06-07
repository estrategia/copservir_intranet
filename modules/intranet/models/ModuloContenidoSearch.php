<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\ModuloContenido;

/**
 * MenuPortalesSearch represents the model behind the search form about `app\modules\intranet\models\MenuPortales`.
 */
class ModuloContenidoSearch extends ModuloContenido
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo'], 'integer'],
            [['tipo', 'titulo', 'descripcion',  'fechaRegistro', 'contenido', 'fechaActualizacion'], 'safe'],
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
        $query = $query = ModuloContenido::find()
        ->where("( tipo =:tipo )")
        ->addParams([':tipo' => ModuloContenido::TIPO_GROUP_MODULES]);

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
            'tipo' => $this->tipo,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'fechaRegistro' => $this->fechaRegistro,
            'contenido' => $this->contenido,
            'fechaActualizacion'=>  $this->fechaActualizacion

        ]);



        return $dataProvider;
    }
}
