<style>input[type="checkbox"]{opacity:1 !important}</style>
<?php
use yii\grid\GridView;
use yii\helpers\Html;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremios;

$this->title = 'Redenciones';

$this->params['breadcrumbs'][] = $this->title;
?>
 <?= Html::a('Pendientes', ['redenciones', 'estado' => UsuariosPremios::ESTADO_PENDIENTE], ['class' => 'btn btn-primary']) ?>
 <?= Html::a('Tramitadas', ['redenciones', 'estado' => UsuariosPremios::ESTADO_TRAMITADO], ['class' => 'btn btn-default']) ?>
 <?= Html::a('Canceladas', ['redenciones', 'estado' => UsuariosPremios::ESTADO_CANCELADO], ['class' => 'btn btn-danger']) ?>


<?= Html::a('Descargar', ['exportar-redenciones'], ['class' => 'btn btn-warning']) ?>
<h1><?php echo $this->title?></h1>
  <?= GridView::widget([
  		'id' => 'gridRedenciones',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'idUsuarioPremio',
            'numeroDocumento',
        	[
        		'label' => 'Nombre Completo',
        		'value' => function($model){return  $model->objUsuario->objUsuarioIntranet->nombres." ".
        											$model->objUsuario->objUsuarioIntranet->primerApellido." ".
        											$model->objUsuario->objUsuarioIntranet->segundoApellido;}
        	],
        	[
	        	'label' => 'Cargo',
	        	'value' => function($model){return  $model->objUsuario->objUsuarioIntranet->nombreCargo;}
        	],
            'cantidad',
            [
            	'attribute' => 'estado',
            	'value' => function($model){return \yii::$app->params['formacioncomunicaciones']['estadosPremios'][$model->estado];},
            	'filter'=>false
            	 
            ],
            [
            'attribute' => 'Premio',
            'value' => function($model){return $model->objPremio->nombrePremio;}
            ],
        	'fechaCreacion',
        	['class' => 'yii\grid\CheckboxColumn'],
        	[
              'class' => 'yii\grid\ActionColumn',
              'headerOptions'=> ['style'=>'width: 70px;'],
              'template' => '{detalle} {actualizar} {eliminar}',
              'buttons' => [
                'detalle' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-correct"></span>', $url);
                },
                'actualizar' => function ($url, $model) {
                  return  Html::a('<span class="glyphicon glyphicon-cancel"></span>', $url);
                },
              ],
            ],
        ],
    ]); ?>
    <?php if($estado != UsuariosPremios::ESTADO_CANCELADO):?>            
	    <button type='button' data-role='tramitar-redenciones' class='btn btn-default' data-estado='<?php echo UsuariosPremios::ESTADO_TRAMITADO?>'>Tramitar</button>
	    <button type='button' data-role='tramitar-redenciones' class='btn btn-danger' data-estado='<?php echo UsuariosPremios::ESTADO_CANCELADO?>'>Cancelar</button>
    <?php endif;?>            