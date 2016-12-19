<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\proveedores\models\UsuarioProveedor */

$this->title = 'Crear Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Gestion de Usuarios', 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

<h3><?= Html::encode($this->title) ?></h3>

<?= $this->render('_form', [
  'model' => $model,
  'terceros' => $terceros,
  'unidadesNegocio' => $unidadesNegocio,
  'ciudades' => $ciudades,
]) ?>

</div>

