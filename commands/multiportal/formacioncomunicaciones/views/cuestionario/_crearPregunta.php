<?php
use yii\helpers\Html;
use app\modules\intranet\modules\formacioncomunicaciones\models\Pregunta;

$this->title = 'Crea Cuestionario';
$this->params['breadcrumbs'][] = ['label' => 'Cuestionarios', 'url' => ['/intranet/formacioncomunicaciones/cuestionario']];
$this->params['breadcrumbs'][] = ['label' => 'Crear cuestionario', 'url' => ['/intranet/formacioncomunicaciones/cuestionario/preguntas', 'id' => $params['model']->idCuestionario]];
$this->params['breadcrumbs'][] = ['label' => 'Preguntas' ];
?>

	<p>
        <?= Html::a('Actualizar', ['actualizar-pregunta', 'id' => $params['model']->idPregunta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Contenido', ['contenido-pregunta', 'idPregunta' => $params['model']->idPregunta], ['class' => 'btn btn-primary']) ?>
        <?php if($params['model']->idTipoPregunta != Pregunta::PREGUNTA_COMPLETAR):?>
        	<?= Html::a('Opciones respuesta', ['opciones-respuesta', 'idPregunta' => $params['model']->idPregunta], ['class' => 'btn btn-primary',]) ?>
    	<?php else:?>
    		<?= Html::a('Opciones respuesta', ['pregunta-completar', 'idPregunta' => $params['model']->idPregunta], ['class' => 'btn btn-primary',]) ?>
    	<?php endif;?>
    </p>
<div class="pregunta-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render($params['view'], $params) ?>
</div>
