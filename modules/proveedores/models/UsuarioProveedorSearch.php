<?php

namespace app\modules\proveedores\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\proveedores\models\UsuarioProveedor;

/**
 * UsuarioProveedorSearch represents the model behind the search form about `app\modules\proveedores\models\UsuarioProveedor`.
 */
class UsuarioProveedorSearch extends UsuarioProveedor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'telefono', 'celular'], 'integer'],
            [['nombre', 'primerApellido', 'segundoApellido', 'email', 'nitLaboratorio', 'nombreLaboratorio', 'profesion', 'fechaNacimiento', 'Ciudad', 'Direccion', 'Rol'], 'safe'],
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
    public function search($params, $nitLaboratorio, $paginacion, $modulo)
    {
        $query = UsuarioProveedor::find();
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
        $this->modulo = $modulo;
        // $usuarioIntranet = \app\models\Usuario::findOne(['numeroDocumento' => $this->numeroDocumento]);
        // $this->estado = $usuarioIntranet->estado;

        $usuarioLogueado = Yii::$app->user->identity;
        $query->innerJoin('auth_assignment', 'auth_assignment.user_id = numeroDocumento');
        if ($usuarioLogueado->tienePermiso('intranet_admin-proveedores')) {
            // $query->andWhere("auth_assignment.item_name='proveedores_admin'");
            $query->where(['and', ['auth_assignment.item_name' => ['proveedores_admin', 'visitaMedica_visitador']]]);
        } else
        if ($usuarioLogueado->tienePermiso('proveedores_admin')) {
            $query->andWhere("auth_assignment.item_name!='proveedores_admin'");
            $query->andWhere("nitLaboratorio='{$nitLaboratorio}'");
        }
        // if ($usuarioLogueado->tienePermiso('visitaMedica_proveedor')) {
        //     $query->andWhere("auth_assignment.item_name='visitaMedica_visitador'");
        //     $query->andWhere("nitLaboratorio='{$nitLaboratorio}'");
        // }
        // grid filtering conditions
        $query->andFilterWhere([
            'numeroDocumento' => $this->numeroDocumento,
            'telefono' => $this->telefono,
            'celular' => $this->celular,
            'fechaNacimiento' => $this->fechaNacimiento,
            // 'modulo' => $this->modulo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'primerApellido', $this->primerApellido])
            ->andFilterWhere(['like', 'segundoApellido', $this->segundoApellido])
            ->andFilterWhere(['like', 'email', $this->email])
            // ->andFilterWhere(['like', 'nitLaboratorio', $this->nitLaboratorio])
            ->andFilterWhere(['like', 'profesion', $this->profesion])
            ->andFilterWhere(['like', 'Ciudad', $this->Ciudad])
            ->andFilterWhere(['like', 'Direccion', $this->Direccion]);
        return $dataProvider;
    }
}
