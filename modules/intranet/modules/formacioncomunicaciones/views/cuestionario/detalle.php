<?php
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Cuestionarios', 'url' => ['/intranet/formacioncomunicaciones/cuestionario']];
$this->params['breadcrumbs'][] = ['label' => $params['model']->tituloCuestionario];
?>
<div class="linea-tiempo-view">
<?php //yii\helpers\VarDumper::dump($params,1,true) ?>
    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $params['model']->idCuestionario], ['class' => 'btn btn-primary']) ?>
        <?php if($params['model']->idContenido != null):?>
        	<?= Html::a('Preguntas', ['preguntas', 'id' => $params['model']->idCuestionario], ['class' => 'btn btn-primary']) ?>
        <?php endif;?>
        <?= Html::a('Inactivar', ['eliminar', 'id' => $params['model']->idCuestionario], [
        		
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de inactivar este cuestionario?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

	<?php echo $this->render($params['view'], $params)?>

</div>
