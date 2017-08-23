<style>input[type="checkbox"]{opacity:1 !important}</style>
<?php
use yii\grid\GridView;
use yii\helpers\Html;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremios;
use app\modules\intranet\modules\formacioncomunicaciones\models\Premio;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = 'Redenciones';

$this->params['breadcrumbs'][] = $this->title;
?>
 <?= Html::a('Pendientes', ['redenciones', 'estado' => UsuariosPremios::ESTADO_PENDIENTE], ['class' => 'btn btn-primary']) ?>
 <?= Html::a('Tramitadas', ['redenciones', 'estado' => UsuariosPremios::ESTADO_TRAMITADO], ['class' => 'btn btn-default']) ?>
 <?= Html::a('Canceladas', ['redenciones', 'estado' => UsuariosPremios::ESTADO_CANCELADO], ['class' => 'btn btn-danger']) ?>


<?= Html::a('Exportar Excel', ['exportar-redenciones'], ['class' => 'btn btn-warning']) ?>
    
<h1><?php echo $this->title?></h1>
<?php $premios = Premio::findAll(['estado' => 1]);?>
<!-- <div class="row"> -->
  <?= GridView::widget([
        'id' => 'gridRedenciones',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'imagen',
                'format' => 'html',
                'value' => function ($model) {
                return Html::img(Yii::getAlias('@web').\Yii::$app->params['formacioncomunicaciones']['rutaImagenPremios'].$model->objPremio->rutaImagen ,
                        ['width' => '80px']);
                },
            ],
            [
            'attribute' => 'Premio',
            'value' => function($model){return $model->objPremio->nombrePremio;},
            /*'filter' => Html::activeDropDownList($searchModel, 'idPremio',  ArrayHelper::map($premios, 'idPremio','descripcionPremio'),
                    ['class'=>'form-control','prompt' => 'Seleccione']),
            ],*/
            'filter' => Select2::widget([
                    'name' => 'UsuariosPremios[idPremio]',
                    'data' => ArrayHelper::map($premios, 'idPremio','descripcionPremio'),
                    'options' => [
                            'placeholder' => 'Seleccione...',
                    ],
                    
            ]),
            ],
            [ 'label' => 'numeroDocumento',
              'format' => 'html',
              'value' => function($model){return Html::a($model->numeroDocumento,["/intranet/usuario/ver",'documento' => $model->numeroDocumento],['target' => '_blank']);}
            ],
            [
                'label' => 'Nombre Completo',
                'format' => 'html',
                'value' => function($model){return  Html::a($model->objUsuario->objUsuarioIntranet->nombres." ".
                                                    $model->objUsuario->objUsuarioIntranet->primerApellido." ".
                                                    $model->objUsuario->objUsuarioIntranet->segundoApellido,["/intranet/usuario/ver",'documento' => $model->numeroDocumento],['target' => '_blank']);},
                'filter' => Select2::widget([
                                'name' => 'UsuariosPremios[numeroDocumento]',
                                'data' => ArrayHelper::map(UsuariosPremios::obtenerUsuarios(), 'numeroDocumento',function($obj){return $obj->nombres." ".$obj->primerApellido." ".
                                                        $obj->segundoApellido;}),
                                'options' => [
                                    'placeholder' => 'Seleccione...',
                                    ]
                            ]),
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
            
            
            ['attribute' => 'fechaCreacion', 'filter' => false],
            ['attribute' => 'fechaEntrega', 'filter' => false],
            ['class' => 'yii\grid\CheckboxColumn'],
            // [
            //   'class' => 'yii\grid\ActionColumn',
            //   'headerOptions'=> ['style'=>'width: 70px;'],
            //   'template' => '{detalle} {actualizar} {eliminar}',
            //   'buttons' => [
            //     'detalle' => function ($url, $model) {
            //       return  Html::a('<span class="glyphicon glyphicon-correct"></span>', $url);
            //     },
            //     'actualizar' => function ($url, $model) {
            //       return  Html::a('<span class="glyphicon glyphicon-cancel"></span>', $url);
            //     },
            //   ],
            // ],
        ],
    ]); ?>
<!-- </div> -->
    <?php if($estado != UsuariosPremios::ESTADO_CANCELADO):?>
    <div class='row'>
        <div class='col-md-offset-11 col-md-1'>
            <button type='button' data-role='tramitar-redenciones' class='btn btn-danger' data-estado='<?php echo UsuariosPremios::ESTADO_CANCELADO?>'>Cancelar</button>
        </div>
    </div>
    <?php endif;?>
   <br/><br/>
    
    <div class='row'>
        <div class='col-md-3'>
            <label class="control-label" >Fecha estimada de entrega:</label>
    		<?php echo DatePicker::widget([
			    'name'  => 'fecha_entrega',
    			'id'  => 'fecha_entrega',
    			'pluginOptions' => [
			        'format' => 'yyyy-mm-dd'
			    ]
			]);?>
    	</div>
    	<div class='col-md-6'>
    		<label class="control-label" >Observaciones:</label>
    		<?php echo Html::textarea('observacion',null,['id' => 'observacion','class' =>'form-control']);?>
    	</div>
    	<div class='col-md-3'>
    		 <button type='button' data-role='tramitar-redenciones' class='btn btn-default' data-estado='<?php echo UsuariosPremios::ESTADO_TRAMITADO?>'>Tramitar</button>
    	</div>
    </div>            