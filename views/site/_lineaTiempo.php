<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$form = ActiveForm::begin([
            'id' => 'nuevoPOST',
            'method' => 'POST',
            'enableClientValidation' => true,
            //'enableAjaxValidation' => true,
            'options' => [
                'enctype' => 'multipart/form-data',
                'data-pjax' => true
            ],
        ]);
?>
<?php echo $form->field($contenidoModel, 'titulo')->input(['value' => 1]); ?>
<?php
echo $form->field($contenidoModel, 'contenido')->widget(Widget::className(), [
    'id' => "post_" . $linea->idLineaTiempo,
    'settings' => [
        'lang' => 'es',
        'minHeight' => 200,
        'imageUpload' => Url::toRoute('site/image-upload'),
        'plugins' => [
            //'clips',
            'imagemanager',
        ],
    ]
])/* ->label(false) */;
?>
<?= Html::hiddenInput("Contenido[idLineaTiempo]", $linea->idLineaTiempo, ["id" => "idLineaTiempo"]); ?>
<?php $requiere = ($linea->autorizacionAutomatica == 0) ? ' (Requiere aprobación)' : ''; ?>
<?= Html::button(Yii::t('app', 'Publicar Noticia' . $requiere), ['class' => 'btn btn-primary', 'data-role' => 'guardar-contenido', 'data-href' => '#lt' . $linea->idLineaTiempo]) ?>
<?php ActiveForm::end(); ?>

<!-- las noticias -->

<?php foreach ($noticias as $noticia): ?>
    <div class="profile-pic">
        <img src=<?= Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->imagenPerfil; ?> alt="" data-src="" data-src-retina="" width="40" height="30" />
    </div>
    <h6><?= $noticia->titulo ?></h6> <i>@<?= $noticia->objUsuarioPublicacion->alias ?></i> <?= $noticia->fechaInicioPublicacion ?>
    <?= $noticia->contenido ?>
<?php endforeach; ?>
