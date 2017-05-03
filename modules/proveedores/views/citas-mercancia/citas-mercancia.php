<?php
use yii\helpers\Html;

//var_dump(Yii::$app->user->identity->objUsuarioProveedor);

$id = Yii::$app->user->identity->objUsuarioProveedor->numeroDocumento;
$cod_prov = Yii::$app->user->identity->objUsuarioProveedor->idTercero;
$name_prov = Yii::$app->user->identity->objUsuarioProveedor->nombreLaboratorio;
?>

<div class="container">
<h1>Citas Entrega de Mercancia</h1>
	<object width="100%" height="1200px" data="http://www.copservir.com/AgendaCitasCedi/frontend/web/index.php?user=<?=$id?>"></object>
</div>