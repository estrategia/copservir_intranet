<?php

namespace app\models;

use Yii;

/**
* modelo que agrupa las variables necesarias para generar el reporte y la calificacion
*/

class SIICOP
{
	/**
	 * Peticion webService soap de las unidades de negocio
	 * @return array
	 */
	 public static function wsGetUnidadesNegocio($opcion=0)
	 {
			 $client = new \SoapClient(\Yii::$app->params['webServices']['tradeMarketing']['unidades'], array(
					 "trace" => 1,
					 "exceptions" => 0,
					 'connection_timeout' => 5,
					 //'cache_wsdl' => WSDL_CACHE_NONE
			 ));

			 try {
			 	$result = $client->getUnidades();
			 	
			 	if($opcion==1){
			 		$resulAux = array();
			 		foreach ($result as $unidad){
			 			$resulAux[$unidad['IdAgrupacion']]=$unidad['NombreUnidadNegocio'];
			 		}
			 		$result=$resulAux;
			 	}	
			 		
				return $result;
			 } catch (SoapFault $ex) {
					 Yii::error($ex->getMessage());
			 } catch (Exception $ex) {
					 Yii::error($ex->getMessage());
			 }
	 }
}

?>
