<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\trademarketing\models\Categoria;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\Categoria */

$this->title = 'Detalle categoria';
//$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-Categorías'), 'url' => ['/trademarketing/categoria']];
$this->params['breadcrumbs'][] = "Detalle";
?>

<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idCategoria], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactivar', ['inactivar', 'id' => $model->idCategoria], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de inactivar esta categoria?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'descripcion',
            [
              'attribute' => 'estado',
              'value' =>  $model->estado == Categoria::ESTADO_ACTIVO ? 'Activo' : 'Inactivo',
            ],
        ],
    ]) ?>

</div>

