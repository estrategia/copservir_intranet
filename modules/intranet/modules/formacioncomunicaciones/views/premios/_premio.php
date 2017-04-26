<div class='col-md-4'>
	<img src='<?= Yii::getAlias('@web').\Yii::$app->params['formacioncomunicaciones']['rutaImagenPremios']?><?= $model->rutaImagen ?>'/><br/>
	<?= $model->nombrePremio ?><br/>
	
	<fieldset>
		<?= $model->descripcionPremio ?>
	</fieldset><br/>
	
	Puntos: <?= $model->puntosRedimir?><br/>
	Cantidad <input class='input-sm' name='cantidad_<?php echo $model->idPremio?>' id='cantidad_<?php echo $model->idPremio?>'/><br/>
	<a href='#' data-role='redimir-premio' data-premio='<?php echo $model->idPremio?>' class='btn btn-primary'>Redimir</a>
</div>