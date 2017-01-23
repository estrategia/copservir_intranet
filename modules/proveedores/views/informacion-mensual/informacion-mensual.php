<?php
use yii\helpers\Html;

//var_dump(Yii::$app->user->identity->objUsuarioProveedor);

$id = Yii::$app->user->identity->objUsuarioProveedor->numeroDocumento;
$cod_prov = Yii::$app->user->identity->objUsuarioProveedor->idFabricante;
$name_prov = Yii::$app->user->identity->objUsuarioProveedor->nombreLaboratorio;
?>

<div class="container">
<h1>Inventario Rotación Mensual</h1>
	
	
	<iframe src="http://intranet2.copservir.com/proveedores/docs/entrega_informacion_mensual_multiportal.php?id=<?=$id?>&cod_prov=<?=$cod_prov?>&name_prov=<?=$name_prov?>" width="100%" height="1200" frameborder="0">
  <p>Your browser does not support iframes.</p>
</iframe>
	
</div>