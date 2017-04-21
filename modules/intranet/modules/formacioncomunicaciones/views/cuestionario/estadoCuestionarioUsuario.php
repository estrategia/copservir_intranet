<?php
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$src = Yii::$app->homeUrl . 'img/formacioncomunicaciones/';
$this->title = "Cuestionarios por usuario";
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Cuestionarios por usuario</h1>
<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'numeroDocumento')->widget(Select2::classname(), [
		'data' => $usuarios,
		'options' => ['placeholder' => 'Selecione ...'],
		'pluginOptions' => [
				'allowClear' => true
		],
]);?>
    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    
    <?php if($usuario):?>
    <?php echo $this->render('_viewInfoUsuario', ['usuario' => $usuario]);?>
    <?php endif;?>
    <table class='table table-striped table-bordered'>
		<tr>
			<th></th>
			<th>T&iacute;tulo Cuestionario </th>
			<th>Curso </th>
			<th>Mejor calificaci&oacute;n </th>
			<th>Aprobado </th>
			<th></th>
		</tr>
		<?php $i = 0;?>
		<?php if(count($cuestionarios) > 0):?>
			<?php foreach($cuestionarios as $intento):?>
				<tr>
					<td><?php echo ++$i;?></td>
					<td><?php echo $intento->objCuestionario->tituloCuestionario?></td>
					<td><?php echo $intento->objCuestionario->objCurso->nombreCurso?></td>
					<td><?php echo $intento->objCuestionario->getCalificacion($intento->numeroDocumento)?></td>
					<td><?php if ($intento->objCuestionario->cuestionarioAprobado($intento->numeroDocumento)):?>
								<img style='margin:0 auto;' src='<?= $src."correct.png"?>'/>
						<?php else:?>
								<img style='margin:0 auto;' src='<?= $src."mistake.png"?>'/>
						<?php endif;?>
					</td>
					<td><?php echo Html::a('Ver m&aacute;s',['detalle-cuestionario','idCuestionario' => $intento->idCuestionario, 'numeroDocumento' => $intento->numeroDocumento])?>
				</tr>
			<?php endforeach;?>
		<?php else:?>
		<tr> <td colspan='4' >No tiene cuestionarios resueltos</td></tr>	
		<?php endif;?>
	</table>