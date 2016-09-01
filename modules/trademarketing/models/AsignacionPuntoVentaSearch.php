<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\AsignacionPuntoVenta;

/**
 * AsignacionPuntoVentaSearch representa el modelo detrás de la forma de búsqueda de `app\modules\trademarketing\models\AsignacionPuntoVenta`.
 */
class AsignacionPuntoVentaSearch extends AsignacionPuntoVenta
{

    public function rules()
    {
        return [
            [['idAsignacion', 'idCiudad', 'idZona', 'idSede', 'numeroDocumento', 'numeroDocumentoAdministradorPuntoVenta',
              'numeroDocumentosubAdministradorpuntoVenta', 'estado'], 'integer'],
            [['idComercial', 'NombrePuntoDeVenta', 'nombreTipoNegocio', 'nombreZona', 'nombreSede', 'fechaAsignacion'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Crea una instancia dataProvider con la query para aplicar la busqueda.
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AsignacionPuntoVenta::find()->where([ 'estado'=> AsignacionPuntoVenta::ESTADO_PENDIENTE,
          'numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idAsignacion' => $this->idAsignacion,
            'idCiudad' => $this->idCiudad,
            'idZona' => $this->idZona,
            'idSede' => $this->idSede,
            'numeroDocumento' => $this->numeroDocumento,
            'numeroDocumentoAdministradorPuntoVenta' => $this->numeroDocumentoAdministradorPuntoVenta,
            'numeroDocumentosubAdministradorpuntoVenta' => $this->numeroDocumentosubAdministradorpuntoVenta,
            'estado' => $this->estado,
            'fechaAsignacion' => $this->fechaAsignacion,
        ]);

        $query->andFilterWhere(['like', 'idComercial', $this->idComercial])
            ->andFilterWhere(['like', 'NombrePuntoDeVenta', $this->NombrePuntoDeVenta])
            ->andFilterWhere(['like', 'nombreTipoNegocio', $this->nombreTipoNegocio])
            ->andFilterWhere(['like', 'nombreZona', $this->nombreZona])
            ->andFilterWhere(['like', 'nombreSede', $this->nombreSede]);

        return $dataProvider;
    }

    public function searchAll($params)
    {
        $query = AsignacionPuntoVenta::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idAsignacion' => $this->idAsignacion,
            'idCiudad' => $this->idCiudad,
            'idZona' => $this->idZona,
            'idSede' => $this->idSede,
            'numeroDocumento' => $this->numeroDocumento,
            'numeroDocumentoAdministradorPuntoVenta' => $this->numeroDocumentoAdministradorPuntoVenta,
            'numeroDocumentosubAdministradorpuntoVenta' => $this->numeroDocumentosubAdministradorpuntoVenta,
            'estado' => $this->estado,
            'fechaAsignacion' => $this->fechaAsignacion,
        ]);

        $query->andFilterWhere(['like', 'idComercial', $this->idComercial])
            ->andFilterWhere(['like', 'NombrePuntoDeVenta', $this->NombrePuntoDeVenta])
            ->andFilterWhere(['like', 'nombreTipoNegocio', $this->nombreTipoNegocio])
            ->andFilterWhere(['like', 'nombreZona', $this->nombreZona])
            ->andFilterWhere(['like', 'nombreSede', $this->nombreSede]);

        return $dataProvider;
    }
}
