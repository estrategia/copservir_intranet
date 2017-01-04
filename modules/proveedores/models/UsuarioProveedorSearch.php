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
    public $rol;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'telefono', 'celular'], 'integer'],
            [['nombre', 'primerApellido', 'segundoApellido', 'email', 'nitLaboratorio', 'nombreLaboratorio', 'profesion', 'fechaNacimiento', 'Ciudad', 'Direccion', 'rol'], 'safe'],
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
        $this->load($params);
        $this->nitLaboratorio = $nitLaboratorio;
        // $this->modulo = $modulo;
        // $usuarioIntranet = \app\models\Usuario::findOne(['numeroDocumento' => $this->numeroDocumento]);
        // $this->estado = $usuarioIntranet->estado;

        $usuarioLogueado = Yii::$app->user->identity;
        $query->leftJoin('auth_assignment', 'auth_assignment.user_id = numeroDocumento');
        $query->distinct();
        if ($usuarioLogueado->tienePermiso('intranet_admin-proveedores')) {
            // $query->andWhere("auth_assignment.item_name='proveedores_admin'");
            // var_dump($this->rol);exit();
            if ($this->rol != "") {
                $query->where(['and', ['auth_assignment.item_name' => [$this->rol]]]);
            }
        } else
        if ($usuarioLogueado->tienePermiso('proveedores_admin')) {
            $query->andWhere("auth_assignment.item_name!='proveedores_admin'");
            $query->andWhere("nitLaboratorio='{$nitLaboratorio}'");
            $query->andWhere("numeroDocumento!='{$usuarioLogueado->numeroDocumento}'");
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'nitLaboratorio' => $this->nitLaboratorio,
        // ]);

        if (!$paginacion) {
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => ['pageSize' => 10],
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => false,
            ]);
        }

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'numeroDocumento', $this->numeroDocumento])
            ->andFilterWhere(['like', 'primerApellido', $this->primerApellido])
            ->andFilterWhere(['like', 'segundoApellido', $this->segundoApellido])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nombreLaboratorio', $this->nombreLaboratorio])
            ->andFilterWhere(['like', 'nitLaboratorio', $this->nitLaboratorio])
            ->andFilterWhere(['like', 'profesion', $this->profesion])
            ->andFilterWhere(['like', 'Ciudad', $this->Ciudad])
            ->andFilterWhere(['like', 'Direccion', $this->Direccion]);
        return $dataProvider;
    }
}
