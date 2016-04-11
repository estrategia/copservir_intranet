<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\InformacionContactoOferta */

$this->title = $model->nombrePlantilla;
//$this->params['breadcrumbs'][] = ['label' => 'Informacion Contacto Ofertas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacion-contacto-oferta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->idInformacionContacto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->idInformacionContacto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'estas seguro de eliminar esta plantilla?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idInformacionContacto',
            'nombrePlantilla',
            'plantillaContactoHtml:ntext',
            //'estado',
            'fechaRegistro',
            //'numeroDocumento',
        ],
    ]) ?>

</div>
