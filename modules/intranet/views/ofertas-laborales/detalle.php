<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */

$this->title = $model->idOfertaLaboral;
$this->params['breadcrumbs'][] = ['label' => 'Ofertas Laborales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ofertas-laborales-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idOfertaLaboral], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idOfertaLaboral], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar esta oferta laboral?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idOfertaLaboral',
            'cargo',
            'idContenidoDestino',
            'idCiudad',
            'fechaPublicacion',
            'fechaCierre',
            'idUsuarioPublicacion',
            'fechaInicioPublicacion',
            'fechaFinPublicacion',
            'tituloOferta',
            'urlElEmpleo:url',
            'idCargo',
            'idArea',
            'descripcionContactoOferta:ntext',
            'idInformacionContacto',
        ],
    ]) ?>

</div>
