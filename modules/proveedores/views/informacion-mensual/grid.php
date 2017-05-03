<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>


	<?php Pjax::begin(['id' => 'list_data', 'enablePushState' => false]); ?>
	<?= GridView::widget([
		'id' => 'gridRotacionMes',
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			//'IdInventarioRotacionMes',
			//'Sucursal',
			//'CodigoPDV',
			'NombrePDV',
			'NombreCiudad',
			'CodigoProducto',
			'NombreProducto',
			'PresentacionProducto',
			//'CodigoProveedor',
			//'NombreProveedor',
			'Inventario',
			'Rotacion',		
		],
	]) 
	?>
	
	<?php Pjax::end(); ?>
		
</div>				