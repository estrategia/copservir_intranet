<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\base\Model;

/**
* modelo que agrupa las variables necesarias para generar el reporte y la calificacion
*/

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
	public $valoresReporte;

	function __construct() {
  }

	/**
	* Consulta e inicializa los modelos necesarios para realizar la calificacion de una asignacion
	* @param integer $idAsignacion
	*/
	public function generarValoresCalificacion($idAsignacion)
	{
			$this->asignacion = $this->consultarAsignacion($idAsignacion);
			$this->consultarCategoriasConVariables();
			$this->unidadesNegocio = $this->callWSGetUnidadesNegocio();
			$this->calificaciones = $this->consultarCalificaciones();
			$this->observaciones = $this->consultarObservaciones();
			$this->porcentajeUnidades = $this->consultarModelosPorcentajesUnidades();
	}

	/**
	* Consulta e inicializa los modelos necesarios para generar los reportes de una asignacion
	* @param integer $idAsignacion
	*/
	public function cearReporte($idAsignacion)
	 {
			 $this->asignacion = $this->consultarAsignacion($idAsignacion);
			 $this->consultarCategoriasConVariables();
			 $this->unidadesNegocio = $this->callWSGetUnidadesNegocio();
			 $this->espacios = $this->consultarEspacios();
			 $this->porcentajeEspacios = $this->consultarPorcentajesEspacio();
			 $this->porcentajeUnidades = $this->consultarPorcentajesUnidades();
			 $this->calificaciones = $this->consultarCalificaciones();
			 $this->observaciones = $this->consultarObservaciones();
			 $this->rangoCalificaciones = $this->consultarRangosCalificacion();
	 }

	 /**
	 * crea un arreglo de modelos CalificacionVariable los cuales son los valores del reporte de evaluacion
	 * @return array
	 */
	 public function generarValoresReporte()
	 {
		 		$arrayCalificaciones = array();

				foreach ($this->unidadesNegocio as $unidad) {
					foreach ($this->espacios as $espacio) {
					$calificacion = null;
					if ($espacio->variable->calificaUnidadNegocio == VariableMedicion::CALIFICA_UNIDAD) {
						$calificacion = CalificacionVariable::find()->where([
							'idAsignacion' => $this->asignacion->idAsignacion,
							'idVariable' => $espacio->variable->idVariable,
							'IdAgrupacion' => $unidad['IdAgrupacion'],
							])->one();
	 				}else{
						$calificacion = CalificacionVariable::find()->where([
							'idAsignacion' => $this->asignacion->idAsignacion,
							'idVariable' => $espacio->variable->idVariable,
							])->one();
					}

					array_push($arrayCalificaciones, $calificacion);
					}
				}

				$this->valoresReporte = $arrayCalificaciones;
	 }

	 /**
	 * consulta un modelo AsignacionPuntoVenta segun el valor de su llave primaria
	 * @return modelo AsignacionPuntoVenta
	 */
	 private function consultarAsignacion($idAsignacion)
	 {
			 if (($model = AsignacionPuntoVenta::findOne($idAsignacion)) !== null) {
					 return $model;
			 } else {
					 throw new NotFoundHttpException('El recurso no existe.');
			 }
	 }

	 /**
	 * Asigna las categorias y sus respectivas variables
	 */
	 private function consultarCategoriasConVariables()
	 {
			 	$this->variables = array();

			 	$this->categorias = Categoria::getCategorias();
				foreach ($this->categorias as $key => $value) {
					$this->variables[$value->nombre] = $value->variablesMedicion;
				}

				//$this->variables = $temp_variables;
	 }

	 /**
	 * Peticion webService soap de las unidades de negocio
	 * @return array
	 */
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

	 /**
	 * consulta todos los modelos Espacio
	 * @return array
	 */
	 private function consultarEspacios()
	 {
	 			return Espacio::find()->all();
	 }

	 /**
	 * consulta todos los modelos RangoCalificaciones
	 * @return array
	 */
	 private function consultarRangosCalificacion()
	 {
	 			return RangoCalificaciones::find()->orderBy('valor')->all();
	 }

	 /**
	 * crea un arreglo de modelos porcentajeEspacios consultados en base a el punto de venta y espacio
	 * @return array
	 */
	 private function consultarPorcentajesEspacio()
	 {
			 $listaPorcentaje = array();

			 foreach ($this->espacios as $espacio) {

				 $porcentaje = Espacio::getPorcentajeEspacio($this->asignacion->idComercial, $espacio->idEspacio);

				 if ($porcentaje != null) {
					 $listaPorcentaje[$espacio->nombre] = $porcentaje->valor;
				 }else{
					 $listaPorcentaje[$espacio->nombre] = '0';
					 //Yii::$app->session->setFlash('error', "Faltan porcentajes para los espacios, los calculos se haran con ceros");
				 }
			 }

			 return $listaPorcentaje;

	 }

	 /**
	 * crea un arreglo de modelos PorcentajeUnidad consultados en base a si asignacion, unidad de negocio
	 * @return array
	 */
	 private function consultarPorcentajesUnidades()
	 {
			 $porcentajeUnidades = array();

			 foreach ($this->unidadesNegocio as $unidad) {

				 $modelo = PorcentajeUnidad::find()->where(['idAsignacion' => $this->asignacion->idAsignacion, 'idAgrupacion' => $unidad['IdAgrupacion']])->one();

				 if ($modelo != null) {
					 $porcentajeUnidades[$unidad['NombreUnidadNegocio']] = $modelo->porcentaje;
				 }else{
					 $porcentajeUnidades[$unidad['NombreUnidadNegocio']] = 0;
					 //Yii::$app->session->setFlash('error', "No se encontraron porcentajes para las unidades, los calculos se haran con ceros");
				 }
			 }

			 return $porcentajeUnidades;
	 }

	 /**
	 * crea un arreglo de modelos PorcentajeUnidad consultados en base a si asignacion, unidad de negocio
	 * @return array
	 */
	 private function consultarModelosPorcentajesUnidades()
	 {
			 $modelosPorcentajeUnidad = array();

			 foreach ($this->unidadesNegocio as $unidad) {
				 $modelo = PorcentajeUnidad::find()->where([ 'idAsignacion' => $this->asignacion->idAsignacion, 'idAgrupacion' => $unidad['IdAgrupacion'] ])->one();

				 if ($modelo !== null) {
					 array_push($modelosPorcentajeUnidad, $modelo);
				 }else{
					 array_push($modelosPorcentajeUnidad, new PorcentajeUnidad());
				 }
			 }

			 return $modelosPorcentajeUnidad;
	 }

	 /**
	 * crea un arreglo de modelos CalificacionVariable consultados en base a su asignacion, variable y/o unidade de negocio
	 * @return array
	 */
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


	 /**
	 * crea un arreglo de modelos Observaciones consultados en base a si asignacion, variable
	 * @return array
	 */
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
