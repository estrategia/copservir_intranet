<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
use app\modules\intranet\modules\formacioncomunicaciones\models\Pregunta;
use app\modules\intranet\modules\formacioncomunicaciones\models\OpcionRespuesta;
?>

<div class="cuestionario-form">
	<strong><label> Enunciado: </label></strong>
	<label><span><?php echo $model->pregunta?></span></label>
    
    <?php if($model->idTipoPregunta != Pregunta::PREGUNTA_COMPLETAR):?>
    	<?php $form = ActiveForm::begin(['options' => ['id' => 'formOpciones']]); ?>
    
	    <div class='row'>
	    	<?= $form->field($modelOpcionRespuesta, 'idPregunta')->hiddenInput(['value' => $model->idPregunta])->label(false); ?>
	    	<?php if($model->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_UNICA || $model->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_MULTIPLE):?>
		    <div class='col-sm-2'>
		    	<?= $form->field($modelOpcionRespuesta, 'respuesta')->textInput(['maxlength' => true]) ?>
		    </div>
		    <div class='col-sm-2'>
		    	<?= $form->field($modelOpcionRespuesta, 'esCorrecta')->dropDownList(['0' => 'No', '1' => 'Si']); ?>
		    </div>
		    <div class='col-sm-3'>
		        <?= Html::Button('Guardar', ['class' => 'btn btn-success', 'data-role' => 'guardarRespuesta', 'data-pregunta' => $model->idPregunta ]) ?>
		    </div>
		    <?php else:?>
		    	<div class='col-sm-2'>
		    		<?= $form->field($modelOpcionRespuesta, 'respuesta')->dropDownList(Yii::$app->params['formacioncomunicaciones']['cuestionario']['opcionesverdaderofalso']) ?>
		    	</div>
		    	<div class='col-sm-3'>
		        	<?= Html::Button('Guardar', ['class' => 'btn btn-success', 'data-role' => 'guardarRespuestaFalsoVerdadero', 'data-pregunta' => $model->idPregunta ]) ?>
		    	</div>
		    <?php endif;?>
		    
		    
		</div>
	    <?php ActiveForm::end(); ?>


		<?= GridView::widget([
			'id' => 'opciones-agregadas',
	        'dataProvider' => $dataProvider,
	        'filterModel' => $searchModel,
	        'pager' => [
	          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
	        ],
	        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
	        'columns' => [
	            ['class' => 'yii\grid\SerialColumn'],
	
	            'respuesta',
	            [
	              'attribute' => 'esCorrecta',
	              'filter' =>
	                Html::activeDropDownList($searchModel, 'esCorrecta', ['0' => 'No', '1' => 'Si'],
	                  ['class'=>'form-control','prompt' => 'Seleccione']),
	              'value' => function($model) {
	                return $model->esCorrecta? 'Si':'No'; 
	              }
	            ],
	            [
	              'class' => 'yii\grid\ActionColumn',
	              'headerOptions'=> ['style'=>'width: 70px;'],
	              'template' => '{editar-opcion}&nbsp;{eliminar-opcion}',
	              'buttons' => [
	                'eliminar-opcion' => function ($url, $model)  {
	                  return  Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', ['data-role' => 'eliminar-opcion', 'data-opcion-respuesta' => $model->idOpcionRespuesta]);
	                },
	                'editar-opcion' => function ($url, $model)  {
	                return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', ['data-role' => 'editar-opcion', 'data-opcion-respuesta' => $model->idOpcionRespuesta]);
	                },
	              ],
	            ],
	        ],
	    ]); ?>
	 <?php else:?>
	 
	 	<?php $form = ActiveForm::begin(['options' => ['id' => 'formOpciones']]); ?>
	 	
	 	<div class='row'>
	    	<?= $form->field($modelPreguntaHija, 'idPreguntaPadre')->hiddenInput(['value' => $model->idPregunta])->label(false); ?>
	    	<?= $form->field($modelPreguntaHija, 'idCuestionario')->hiddenInput(['value' => $model->idCuestionario])->label(false); ?>
	        <div class='col-sm-2'>
		    	<?= $form->field($modelPreguntaHija, 'pregunta')->textInput(['maxlength' => true]) ?>
		    </div>
		    <div class='col-sm-2'>
		    	<?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>
		    </div>
		    <div class='col-sm-2'>
		    	<?= $form->field($model, 'tituloPregunta')->textInput(['maxlength' => true]); ?>
		    </div>
		    <div class='col-sm-3'>
		        <?= Html::Button('Guardar', ['class' => 'btn btn-success', 'data-role' => 'guardarPreguntaCompletar', 'data-pregunta' => $model->idPregunta ]) ?>
		    </div>
		</div>
	 	<?php ActiveForm::end(); ?>
	 	
	 	<?= GridView::widget([
			'id' => 'preguntas-agregadas',
	        'dataProvider' => $dataProvider,
	        'filterModel' => $searchModel,
	        'pager' => [
	          'maxButtonCount' => Yii::$app->params['limiteBotonesPaginador'],    // Set maximum number of page buttons that can be displayed
	        ],
	        'layout' => "{summary}\n{items}\n<center>{pager}</center>",
	        'columns' => [
	            ['class' => 'yii\grid\SerialColumn'],
	        	'pregunta',
	            [
	              'class' => 'yii\grid\ActionColumn',
	              'headerOptions'=> ['style'=>'width: 70px;'],
	              'template' => '{agregar-respuestas} &nbsp; {eliminar-opcion}',
	              'buttons' => [
	                'eliminar-opcion' => function ($url, $model)  {
	                  return  Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', ['data-role' => 'eliminar-pregunta-completar', 'data-opcion-respuesta' => $model->idPregunta]);
	                },
	                'agregar-respuestas' => function ($url, $model)  {
	                return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', ['data-role' => 'agregar-opciones-completar', 'data-pregunta' => $model->idPregunta]);
	                }
	              ],
	            ],
	        ],
	    ]); ?>
	 
	 <?php endif;?>
</div>