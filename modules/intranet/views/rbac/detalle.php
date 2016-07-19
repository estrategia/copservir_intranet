<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
//--------------------


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['actualizar', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['eliminar', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de eliminar este rol?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
        ],
    ]) ?>

</div>
<div class="lista-permisos">
  <?=
    $this->render('_listaPermisos', ['model' => $model,
        'dataProviderPermisos' => $dataProviderPermisos,
        'searchModel' => $searchModel,
        'authItemChild' => $authItemChild,
    ])
  ?>
</div>
