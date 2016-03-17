<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ofertas Laborales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ofertas-laborales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ofertas Laborales', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idOfertaLaboral',
            'cargo',
            'idContenidoDestino',
            'idCiudad',
            'fechaPublicacion',
            // 'fechaCierre',
            // 'idUsuarioPublicacion',
            // 'fechaInicioPublicacion',
            // 'fechaFinPublicacion',
            // 'tituloOferta',
            // 'urlElEmpleo:url',
            // 'idCargo',
            // 'idArea',
            // 'descripcionContactoOferta:ntext',
            // 'idInformacionContacto',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
