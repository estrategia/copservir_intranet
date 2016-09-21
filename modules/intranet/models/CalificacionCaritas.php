<?php

namespace app\modules\intranet\models;
use Yii;

class CalificacionCaritas extends \yii\db\ActiveRecord {

  public static function operacionLrv($idrespuesta,$tiporespuesta,$m,$numeroDeDiasMes)
  {
    /*$db2 = Yii::$app->db2;
    $sql = $db2->createCommand("SELECT count(*) AS cantidad FROM t_calificacionDomicilios WHERE TipoCompra=1 and ExperienciaCalificacion='".$idrespuesta."' and TipoCompra = 1 and HoraRegistro >= '2016-".$m."-01 00:00:00' and HoraRegistro <= '2016-".$m."-".$numeroDeDiasMes." 23:59:59'")
    ->queryOne();
	
	$resultado= $sql["cantidad"]*$tiporespuesta;	
	return $resultado;*/
  	
  	return 10;
  }
}