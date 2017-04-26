<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios */

$this->title = 'Actualizar Categoría: ' . $model->nombreCategoria;
$this->params['breadcrumbs'][] = ['label' => 'Categorías', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombreCategoria, 'url' => ['detalle', 'id' => $model->idCategoria]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="categorias-premios-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#categoria" aria-controls="categoria" role="tab" data-toggle="tab">Categoria</a></li>
      <li role="presentation"><a href="#contacto" aria-controls="contacto" role="tab" data-toggle="tab">Contactos</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="categoria">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
      </div>
      <div role="tabpanel" class="tab-pane" id="contacto">
        <?= $this->render('contactos-categoria', [
            'model' => $model,
        ]) ?>
      </div>
    </div>

</div>
