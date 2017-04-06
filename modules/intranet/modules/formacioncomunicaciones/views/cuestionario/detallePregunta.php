<?php use yii\widgets\DetailView;
use app\modules\intranet\modules\formacioncomunicaciones\models\Cuestionario;
use yii\helpers\Html;

$this->title = 'Detalle de cuestionario';
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
				'tituloCuestionario',
				
				[
						'attribute' => 'estado',
						'value' =>  $model->estado == Cuestionario::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
				],
				'fechaCreacion',
				'fechaActualizacion',
		],
]) ?>
		
		<?php echo $model->descripcionCuestionario?>