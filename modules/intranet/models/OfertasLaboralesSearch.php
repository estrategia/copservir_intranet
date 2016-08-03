<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\OfertasLaborales;

/**
 * OfertasLaboralesSearch represents the model behind the search form about `app\modules\intranet\models\OfertasLaborales`.
 */
class OfertasLaboralesSearch extends OfertasLaborales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idOfertaLaboral', 'numeroDocumento', 'idInformacionContacto'], 'integer'],
            [['fechaPublicacion', 'estado','idCiudad','nombreCargo', 'fechaCierre', 'fechaInicioPublicacion', 'fechaFinPublicacion', 'tituloOferta', 'urlElEmpleo', 'descripcionContactoOferta'], 'safe'],
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
        $query = OfertasLaborales::find();

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
            'idOfertaLaboral' => $this->idOfertaLaboral,
            'fechaPublicacion' => $this->fechaPublicacion,
            'fechaCierre' => $this->fechaCierre,
            'numeroDocumento' => $this->numeroDocumento,
            'fechaInicioPublicacion' => $this->fechaInicioPublicacion,
            'fechaFinPublicacion' => $this->fechaFinPublicacion,
            'estado' => $this->estado,
            'idInformacionContacto' => $this->idInformacionContacto,
        ]);

        $query->joinWith('objCiudad');
        //$query->joinWith('objCargo');

        $query->andFilterWhere(['like', 'nombreCiudad', $this->idCiudad]);
        $query->andFilterWhere(['like', 'nombreCargo', $this->nombreCargo]);
        //$query->andFilterWhere(['like', 'idArea', $this->idArea]);


        $query->andFilterWhere(['like', 'tituloOferta', $this->tituloOferta])
            ->andFilterWhere(['like', 'urlElEmpleo', $this->urlElEmpleo])
            ->andFilterWhere(['like', 'descripcionContactoOferta', $this->descripcionContactoOferta]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchVertodos($params)
    {

        $query = OfertasLaborales::find()->orderby('idCiudad')
          ->with([ 'objCiudad', 'objInformacionContactoOferta']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
              'pageSize' => 1,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idOfertaLaboral' => $this->idOfertaLaboral,
            'fechaPublicacion' => $this->fechaPublicacion,
            'fechaCierre' => $this->fechaCierre,
            'numeroDocumento' => $this->numeroDocumento,
            'fechaInicioPublicacion' => $this->fechaInicioPublicacion,
            'fechaFinPublicacion' => $this->fechaFinPublicacion,

            'idInformacionContacto' => $this->idInformacionContacto,
        ]);

        $query->joinWith('objCiudad');
        //$query->joinWith('objCargo');
        //$query->joinWith('objArea');

        $query->andFilterWhere(['like', 'nombreCiudad', $this->idCiudad]);
        $query->andFilterWhere(['like', 'nombreCargo', $this->nombreCargo]);
        //$query->andFilterWhere(['like', 'nombreArea', $this->idArea]);


        $query->andFilterWhere(['like', 'tituloOferta', $this->tituloOferta])
            ->andFilterWhere(['like', 'urlElEmpleo', $this->urlElEmpleo])
            ->andFilterWhere(['like', 'descripcionContactoOferta', $this->descripcionContactoOferta]);

        return $dataProvider;
    }
}
