<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\intranet\modules\formacioncomunicaciones\models\Premio;
?>
<div class='col-sm-3 col-md-3 item' style="margin-top:30px; ">
	<div class="sub-categoria-item">
		<?php if($model->tipoRedimir == Premio::TIPO_TIENDA):?>
		<div class="puntos">
		  <?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/puntos.png', ['class' => 'img-responsive']) ?> 
		  <span class="quantity"><?= $model->puntosRedimir?> <br> puntos</span>              
		</div>
		<?php endif;?>
		<p align="center">
			<img src='<?= Yii::getAlias('@web').\Yii::$app->params['formacioncomunicaciones']['rutaImagenPremios']?><?= $model->rutaImagen ?>' class="img-responsive"/>
			Cant. Disp. <?= $model->cantidad ?>
		</p>
		<div class="detalle-redencion">
			<h4 class="nombre-sub-categoria"><?= $model->nombrePremio ?></h4>		
			<fieldset><?= $model->descripcionPremio ?></fieldset>	
				
			<label for="cantidad_<?php echo $model->idPremio?>" class="nowrap">Cantidad
			    <input class='input-sm input-cantidad' name='cantidad_<?php echo $model->idPremio?>'<?php echo ($model->tipoRedimir != Premio::TIPO_TIENDA)?'readonly':''?> ondrop='return false' onpaste='return false' id='cantidad_<?php echo $model->idPremio?>' value='1'/>
			</label>
			<?php if($model->tipoRedimir == Premio::TIPO_TIENDA):?>
	        	<a href='#' data-role='redimir-premio' data-premio='<?php echo $model->idPremio?>'>
	        		<?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/redimir.png', ['class' => 'redimir']) ?>
	        	</a> 
        	<?php else:?>
        		<?php if($model->objCuestionario->cuestionarioAprobado()):?>
        		<a href='#' data-role='redimir-premio' data-premio='<?php echo $model->idPremio?>'>
	        		<?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/redimir.png', ['class' => 'redimir']) ?>
	        	</a>
	        	<?php else:?>
	        		<a href='<?php echo Url::to(['curso/visualizar-curso', 'id' => $model->objCuestionario->idCurso])?>' >
        			<?= Html::img(Yii::getAlias('@web').'/img/formacioncomunicaciones/assets/redimir.png', ['class' => 'redimir']) ?>
        			</a>
	        	<?php endif;?>
        	<?php endif;?>
		</div>
	</div>
</div>