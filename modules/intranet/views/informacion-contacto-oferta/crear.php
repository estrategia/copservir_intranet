<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\InformacionContactoOferta */

$this->title = 'Crear una plantilla';
//$this->params['breadcrumbs'][] = ['label' => 'Informacion Contacto Ofertas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informacion-contacto-oferta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
