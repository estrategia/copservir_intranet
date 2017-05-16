<?php
use yii\helpers\Html;
?>

<?php $this->registerJsFile("@web/js/datatable.js", ['depends' => [app\assets\DataTableAsset::className()]]); ?>

<div class="container">
	<h1>Mis Productos <?=Yii::$app->user->identity->objUsuarioProveedor->nombreLaboratorio?></h1>
	<table id="example" class="stripe" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>#</th>
				<th>Código</th>
				<th>Producto</th>
				<th>Referencia</th>
				<th>Imagen</th>
			  
			</tr>
		</thead>

		<tbody>
			<?php $cont = 1; ?>	
			<?php foreach ($result as $datosArray): ?>							
			<?="<tr><td>".$cont."</td><td>".$datosArray->CODIGO_PRODUCTO."</td><td>".$datosArray->DESCRIPCION_PRODUCTO."</td><td>".$datosArray->PRESENTACION_PRODUCTO."</td><td>".($datosArray->RUTA_IMAGEN == null ? "<img src='https://www.larebajavirtual.com/images/productos/noimage.gif' height='150'>" : "<img src='https://www.larebajavirtual.com/images/productos/".$datosArray->RUTA_IMAGEN."' height='150'>")."</td></tr>" ?>
			<?php $cont ++; ?>			
			<?php endforeach; ?>
		</tbody>
	</table>
</div>