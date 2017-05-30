<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Detalle de rol';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['admin']];
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
