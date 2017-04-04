<?php
use yii\helpers\Html;



$this->params['breadcrumbs'][] = ['label' => 'Cuestionario', 'url' => ['/intranet/formacioncomunicaciones/cuestionario']];
$this->params['breadcrumbs'][] = ['label' => 'Ver cuestionario'];
?>
<div class="linea-tiempo-view">

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $params['model']->idCuestionario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Preguntas', ['preguntas', 'id' => $params['model']->idCuestionario], ['class' => 'btn btn-primary']) ?>
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
