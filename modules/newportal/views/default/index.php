<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $generators \yii\gii\Generator[] */
/* @var $content string */

$generators = Yii::$app->controller->module->generators;
$this->title = 'New Portal';
?>
<div class="default-index">
    <div class="page-header">
        <h1>Bienvenido al generador de portales </h1>
    </div>

    <div class="row">
        <?php foreach ($generators as $id => $generator): ?>
        <div class="generator col-lg-4">
            <h3><?= Html::encode($generator->getName()) ?></h3>
            <p><?= $generator->getDescription() ?></p>
            <p><?= Html::a('Crear portal &raquo;', ['default/view', 'id' => $id], ['class' => 'btn btn-default']) ?></p>
            <p><?= Html::a('Administrar portales &raquo;', ['portal/index'], ['class' => 'btn btn-default']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
