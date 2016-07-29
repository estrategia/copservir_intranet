<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use \app\modules\intranet\models\Contenido;

/* @var $this yii\web\View */

$this->title = 'Aprobar contenido';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contenidos por aprobar'), 'url'=>['/intranet/contenido/listar-contenidos-pendientes']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contenido #' . $model->idContenido)];
?>

<div class="col-md-12">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php if ($model->estado == Contenido::PENDIENTE_APROBACION): ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'estado')->hiddenInput(['value'=> Contenido::APROBADO ])->label(false); ?>
    <?= $form->field($model, 'fechaActualizacion')->hiddenInput(['value'=>  Date("Y-m-d H:i:s")])->label(false); ?>
    <?= $form->field($model, 'fechaInicioPublicacion')->hiddenInput(['value'=>  Date("Y-m-d H:i:s")])->label(false); ?>
    <?= $form->field($model, 'fechaAprobacion')->hiddenInput(['value'=>  Date("Y-m-d H:i:s")])->label(false); ?>
    <?= $form->field($model, 'numeroDocumentoAprobacion')->hiddenInput(['value'=>  Yii::$app->user->identity->numeroDocumento])->label(false); ?>
    <div class="form-group col-md-2">
      <?= Html::submitButton('Aprobar contenido', ['class' => 'btn btn-success' ]) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?= Html::a('Eliminar contenido', ['eliminar-contenido', 'id' => $model->idContenido], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Estas seguro de eliminar este contenido?',
        'method' => 'post',
      ],
      ]) ?>

    <?php endif; ?>

    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        'titulo',
        [
          'attribute' =>'contenido',
          'format'=>'raw',
          'value'=>$model->contenido,
        ],
        [
          'label' => 'Linea de tiempo',
          'value'=>$model->objLineaTiempo->nombreLineaTiempo,
        ],
        'fechaPublicacion',
        [
          'label' => 'Publicado por:',
          'format'=>'raw',
          'value' => '<img src="'.Yii::getAlias('@web').'/img/fotosperfil/'. $model->objUsuarioPublicacion->getImagenPerfil().'" class="img-circle img-responsive" style="width: 22%;"/><p>'.$model->objUsuarioPublicacion->alias.' </p> '
        ],
      ],
      ]) ?>

      <?php if ($model->objContenidoAdjuntoImagenes): ?>
        <div class="row">
          <div class="col-md-12">
            <h4>Imagenes asociadas a la publicación</h4>
            <?php $contador = 0; ?>
            <?php foreach ($model->objContenidoAdjuntoImagenes as $imagenes): ?>

              <?php
                $contador++;
                $style = '';
                $mensaje = '';
                if ($contador > \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) {
                  $style = 'display:none';
                }

                if ($contador == \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) {
                  if (($contador) != count($model->objContenidoAdjuntoImagenes)) {
                    $mensaje = (count($model->objContenidoAdjuntoImagenes) - \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) . '+'; // cambiar por una constante
                  }
                }
              ?>
              <div class="col-md-2  col-sm-2">
                <a class="lightbox gallery<?= $model->idContenido ?>"
                  href="<?= Yii::getAlias('@web') . "/img/imagenesContenidos/" . $imagenes->rutaArchivo ?>" style="<?= $style ?>">

                  <div class="slide-front ha slide">
                    <div class="overlayer bottom-left fullwidth">
                      <div class="overlayer-wrapper">
                        <div class="p-l-20 p-r-20 p-b-20 p-t-20" style="text-align:center;">
                          <h1 style="color:#fff !important;"><span class="semi-bold"><?= $mensaje ?></span></h1>
                        </div>
                      </div>
                    </div>
                    <img src="<?= Yii::getAlias('@web') . "/img/imagenesContenidos/" . $imagenes->rutaArchivo ?>" class="img-thumbnail"/>
                  </div>

                </a>
              </div>
            <?php endforeach; ?>
            <?php $this->registerJs("jQuery('.gallery$model->idContenido').lightbox();");?>
            <script type="text/javascript">
                jQuery('.lightbox').lightbox();
            </script>
          </div>
        </div>
      <?php endif; ?>
      <br><br>
    </div>
