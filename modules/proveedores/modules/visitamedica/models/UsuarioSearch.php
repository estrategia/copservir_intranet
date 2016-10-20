<?php

namespace app\modules\proveedores\modules\visitamedica\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\proveedores\modules\visitamedica\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form about `app\modules\proveedores\modules\visitamedica\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'telefono', 'celular'], 'integer'],
            [['nombre', 'primerApellido', 'segundoApellido', 'email', 'nitLaboratorio', 'profesion', 'fechaNacimiento', 'Ciudad', 'Direccion'], 'safe'],
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
    public function search($params, $nitLaboratorio, $paginacion)
    {
        $query = Usuario::find();

        // add conditions that should always apply here

        if (!$paginacion) {
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => false,
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => false,
            ]);
        }


        $this->load($params);
        $this->nitLaboratorio = $nitLaboratorio;

        // grid filtering conditions
        $query->andFilterWhere([
            'numeroDocumento' => $this->numeroDocumento,
            'telefono' => $this->telefono,
            'celular' => $this->celular,
            'fechaNacimiento' => $this->fechaNacimiento,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'primerApellido', $this->primerApellido])
            ->andFilterWhere(['like', 'segundoApellido', $this->segundoApellido])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nitLaboratorio', $this->nitLaboratorio])
            ->andFilterWhere(['like', 'profesion', $this->profesion])
            ->andFilterWhere(['like', 'Ciudad', $this->Ciudad])
            ->andFilterWhere(['like', 'Direccion', $this->Direccion]);

        return $dataProvider;
    }
}
