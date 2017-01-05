<?php

namespace app\modules\proveedores\models;
use Yii;
use yii\data\ActiveDataProvider;

class InformacionMensual extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 't_InventarioRotacionMes';
    }

	public function rules() {      
		return [
			//[["cedula", "nombre", "gerenciaOperativa", "ciudad", "direccion", "contacto", "telefono", "canon", "descripcion", "estado"], "required"],						
			[["IdInventarioRotacionMes"], "string"],
			[["Codigo"], "string"],
			[["Sucursal"], "string"],
			[["CodigoPDV"], "string"],
			[["NombrePDV"], "string"],
			[["NombreCiudad"], "string"],
			[["CodigoProducto"], "string"],
			[["NombreProducto"], "string"],
			[["PresentacionProducto"], "string"],
			[["CodigoProveedor"], "string"],
			[["NombreProveedor"], "string"],
			//[["Inventario"], "string"],
			//[["Rotacion"], "string"],	
		];     
    }
	
	public function attributeLabels()
	{
		return [
			"IdInventarioRotacionMes" => "id",
			"Codigo" => "Código",
			"Sucursal" => "Sucursal",
			"CodigoPDV" => "Cod. PDV",
			"NombrePDV" => "PDV",
			"NombreCiudad" => "Ciudad",
			"CodigoProducto" => "Cod.",
			"NombreProducto" => "Producto",
			"PresentacionProducto" => "REF.",
			"CodigoProveedor" => "Cod. Proveedor",
			"NombreProveedor" => "Proveedor",
			"Inventario" => "Inventario",
			"Rotacion" => "Venta",
		];
	}	
	
	public function search($params)
    {
        $query = InformacionMensual::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		$query->andFilterWhere([
			'CodigoProducto' => $this->CodigoProducto,
		]);

		$query->andFilterWhere(['like', 'NombrePDV', $this->NombrePDV])
			->andFilterWhere(['like', 'NombreCiudad', $this->NombreCiudad])
			->andFilterWhere(['like', 'NombreProducto', $this->NombreProducto])
			->andFilterWhere(['like', 'PresentacionProducto', $this->PresentacionProducto]);

		return $dataProvider;
    }

	
	public function datos()
    {
		$sql = "SELECT * FROM t_InventarioRotacionMes where CodigoProveedor = 16 limit 0,3000";
		$model = InformacionMensual::findBySql($sql)->all(); 	

		return $model ;
    }	

}
