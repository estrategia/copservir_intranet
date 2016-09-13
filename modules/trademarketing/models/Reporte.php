<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;

class Reporte extends Model
{
	public $asignacion;
	public $calificaciones;
	public $espacios;
	public $categorias;
	public $variables;
	public $porcentajeEspacios;
	public $rangoCalificaciones;
	public $observaciones;
	public $porcentajeUnidades;
	public $unidadesNegocio;

	function __construct($idAsignacion) {


				$this->asignacion = $this->consultarAsignacion($idAsignacion);
				$this->consultarCategoriasConVariables();
				$this->unidadesNegocio = $this->callWSGetUnidadesNegocio();
				$this->espacios = $this->consultarEspacios();
				$this->porcentajeEspacios = $this->consultarPorcentajesEspacio();
				$this->porcentajeUnidades = $this->consultarPorcentajesUnidades();
				$this->calificaciones = $this->consultarCalificaciones();
				$this->observaciones = $this->consultarObservaciones();


   }


	 private function consultarAsignacion($idAsignacion)
	 {
			 if (($model = AsignacionPuntoVenta::findOne($idAsignacion)) !== null) {
					 return $model;
			 } else {
					 throw new NotFoundHttpException('El recurso no existe.');
			 }
	 }

	 private function consultarCategoriasConVariables()
	 {
			 	$temp_variables = array();

			 	$this->categorias = Categoria::getCategorias();
				foreach ($this->categorias as $key => $value) {
					$temp_variables[$value->nombre] = $value->variablesMedicion;
				}

				$this->variables = $temp_variables;
	 }

	 private function callWSGetUnidadesNegocio()
	 {
			 $client = new \SoapClient(\Yii::$app->params['webServices']['tradeMarketing']['unidades'], array(
					 "trace" => 1,
					 "exceptions" => 0,
					 'connection_timeout' => 5,
					 //'cache_wsdl' => WSDL_CACHE_NONE
			 ));

			 try {
					 $result = $client->getUnidades();
					 return $result;
			 } catch (SoapFault $ex) {
					 Yii::error($ex->getMessage());
			 } catch (Exception $ex) {
					 Yii::error($ex->getMessage());
			 }
	 }

	 private function consultarEspacios()
	 {
	 			return Espacio::find()->all();
	 }

	 private function consultarRangosCalificacion()
	 {
	 			$this->$rangoCalificaciones = RangoCalificaciones::find()->orderBy('valor')->all();
	 }

	 private function consultarPorcentajesEspacio()
	 {
			 $listaPorcentaje = array();

			 foreach ($this->espacios as $espacio) {

				 $porcentaje = $espacio->getPorcentajeEspacio($this->asignacion->idComercial, $espacio->idEspacio);

				 if ($porcentaje != null) {
					 $listaPorcentaje[$espacio->nombre] = $porcentaje->valor;
				 }else{
					 $listaPorcentaje[$espacio->nombre] = '0';
					 //Yii::$app->session->setFlash('error', "Faltan porcentajes para los espacios, los calculos se haran con ceros");
				 }
			 }

			 return $listaPorcentaje;

	 }

	 private function consultarPorcentajesUnidades()
	 {
			 $porcentajeUnidades = array();

			 foreach ($this->unidadesNegocio as $unidad) {

				 $modelo = PorcentajeUnidad::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idAgrupacion' => $unidad['IdAgrupacion']])->one();

				 if ($modelo != null) {
					 $porcentajeUnidades[$unidad['NombreUnidadNegocio']] = $modelo->porcentaje;
				 }else{
					 $porcentajeUnidades[$unidad['NombreUnidadNegocio']] = 0;
					 Yii::$app->session->setFlash('error', "No se encontraron porcentajes para las unidades, los calculos se haran con ceros");
				 }
			 }

			 return $porcentajeUnidades;
	 }

	 protected function consultarCalificaciones()
	 {
		 $modelosCalificacion = array();

		 foreach ($this->categorias as $categoria) {

			 foreach ($categoria->variablesMedicion as $variable){

				 if ($variable->calificaUnidadNegocio === 1) {

					 foreach ($this->unidadesNegocio as $unidad) {

						 $modelo = CalificacionVariable::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idVariable' => $variable->idVariable, 'IdAgrupacion' => $unidad['IdAgrupacion']])->one();

						 if ($modelo !== null) {
							 array_push($modelosCalificacion, $modelo);
						 }else{
							 array_push($modelosCalificacion, new CalificacionVariable());
						 }
					 }

				 }else{

					 $modelo = CalificacionVariable::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idVariable' => $variable->idVariable])->one();

					 if ($modelo !== null) {
						 array_push($modelosCalificacion, $modelo);
					 }else{
						 array_push($modelosCalificacion, new CalificacionVariable());
					 }
				 }
			 }
		 }

		 return $modelosCalificacion;
	 }


	 protected function consultarObservaciones()
	 {
			 $modelosObservacion = array();

			 foreach ($this->categorias as $categoria) {

				 foreach ($categoria->variablesMedicion as $variable){
						 $modelo = Observaciones::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idVariable' => $variable->idVariable])->one();
						 if ($modelo !== null) {
							 array_push($modelosObservacion, $modelo);
						 }else{
							 array_push($modelosObservacion, new Observaciones);
						 }
				 }
			 }

			 return $modelosObservacion;
	 }
}

?>
