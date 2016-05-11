<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\intranet\models\LineaTiempo;
?>
<ul class="cbp_tmtimeline">
  <li>
    <div class="cbp_tmtime">
      <div class="user-profile text-center">
        <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $noticia->objUsuarioPublicacion->imagenPerfil ?> alt="" data-src="" data-src-retina="" width="80" height="80">
      </div>
      <div class="text-center time"> <?= $noticia->objUsuarioPublicacion->alias ?> </div>

      <?php if (isset($noticia->fechaInicioPublicacion)): ?>
        <?php $fdia = \DateTime::createFromFormat('Y-m-d H:i:s', $noticia->fechaInicioPublicacion) ?>
        <div class="text-center date"> <?= Yii::$app->params['calendario']['dias'][$fdia->format('w')] ?></div>
        <div class="text-center date"> <?= $fdia->format('j') ?> <?= Yii::$app->params['calendario']['mesesAbreviado'][$fdia->format('n')] ?> <?= $fdia->format('Y') ?> </div>
        <div class="text-center date"> <?= $fdia->format('h:i a') ?></div>
      <?php endif; ?>
    </div>

    <div class="cbp_tmicon primary animated bounceIn"> <i class="fa fa-comments"></i> </div> <!-- icono de la noticia -->

    <div class="cbp_tmlabel">
      <div class="p-t-10 p-l-30 p-r-20 p-b-20 xs-p-r-10 xs-p-l-10 xs-p-t-5">

        <?= Html::a('<h4 class="inline m-b-5"><span class="text-success semi-bold"> ' . $noticia->titulo . ' </span> </h4>', ['contenido/detalle-contenido', 'idNoticia' => $noticia->idContenido], ['class' => '', 'name' => '']) ?>
        <h5 class="inline muted semi-bold m-b-5"></h5> <!-- para el usuario que publico la noticia -->
        <!--<div class="muted">Publicación Compartida - 12:45pm</div> si la publicacion fue compartida-->
        <p class="m-t-5 dark-text">
          <?= $noticia->contenido ?>

          <!-- IMAGENES -->

          <?php if (!empty($noticia->objContenidoAdjuntoImagenes)): ?>
             <?php $contador = 0; ?>
            <?php foreach ($noticia->objContenidoAdjuntoImagenes as $imagenes): ?>
                <?php
                  $contador++;
                  $style = '';
                  $mensaje = '';
                  if ($contador>1) { //cambiar por una constante
                    $style = 'display:none';
                  }
                  if ($contador=1 && ($contador-1) != 0) { //cambiar por una constante
                    $mensaje = (count($noticia->objContenidoAdjuntoImagenes)-1).'+' ;
                  }
                ?>

              <a class="lightbox gallery<?=$noticia->idContenido?>" href="<?= Yii::getAlias('@web')."/img/imagenesContenidos/".$imagenes->rutaArchivo ?>" style="<?= $style ?>">
                <div class="col-md-6  col-sm-6" data-aspect-ratio="true">
                    <div class="slide-front ha tiles green  slide">
                      <div class="overlayer bottom-left fullwidth">
                        <div class="overlayer-wrapper">
                          <div class="tiles gradient-black p-l-20 p-r-20 p-b-20 p-t-20" style="text-align:center;">
                            <h1 style="color:#fff !important;"><span class="semi-bold"><?= $mensaje ?></span></h1>
                          </div>
                        </div>
                      </div>
                        <img src="<?= Yii::getAlias('@web')."/img/imagenesContenidos/".$imagenes->rutaArchivo ?>" class="img-thumbnail" />
                     </div>
                </div>
              </a>

            <?php endforeach; ?>
            <?php
              $this->registerJs("

                jQuery('.gallery$noticia->idContenido').lightbox();

              ");
            ?>
            <script type="text/javascript">
              jQuery('.lightbox').lightbox();
            </script>
          <?php endif; ?>

        </p>
      </div>


      <!-- comentarios y me gusta -->

      <?php if ($noticia->objLineaTiempo->tipo === LineaTiempo::LINEA_CON_COMENTARIOS): ?>
      <!--<div class="p-t-10 p-b-10 p-l-20 ">-->

        <ul class="action-links col-md-12" style="border-bottom:1px solid #eee;border-top: 1px solid #eee;padding: 5px;">
          <li>
            <?php $noExisteMeGusta = (empty($noticia->listMeGustaUsuario) || count($noticia->listMeGustaUsuario) < 1) ?>

            <a id='megusta_<?= $noticia->idContenido ?>' class="" data-role='me-gusta-contenido' data-contenido='<?= $noticia->idContenido ?>' data-value='1' style='display: <?= $noExisteMeGusta ? '' : 'none' ?>'>
            <span class="glyphicon glyphicon-thumbs-up"></span> Me gusta</a>

            <a id='no_megusta_<?= $noticia->idContenido ?>' class="" data-role='me-gusta-contenido' data-contenido='<?= $noticia->idContenido ?>' data-value='0' style='display: <?= $noExisteMeGusta ? 'none' : '' ?>'>
            <span class="glyphicon glyphicon-thumbs-down"></span> Ya no me gusta</a>


            <?php // echo ($megusta > 0 )? $megusta ." Me Gusta": '' ?> &nbsp;
            <span id='numero-megusta_<?= $noticia->idContenido ?>'>
            <?php
            echo (count($noticia->listMeGusta) > 0 ) ?
            Html::a(count($noticia->listMeGusta) . " Me Gusta", '#', [
            //'id' => 'showFormPublications' . $linea->idLineaTiempo,
            'data-role' => 'listado-me-gusta-contenido',
            'data-contenido' => $noticia->idContenido,
            'onclick' => 'return false'
            ]) : ''
            ?> &nbsp;
            </span>
            <span id='numero-comentarios_<?= $noticia->idContenido ?>'>
            <?php
            echo (count($noticia->listComentarios) > 0 ) ? Html::a(count($noticia->listComentarios) . " Comentarios", '#', [
            //'id' => 'showFormPublications' . $linea->idLineaTiempo,
            'data-role' => 'listado-comentarios-contenido',
            'data-contenido' => $noticia->idContenido,
            'onclick' => 'return false'
            ]) : ''
            ?>  &nbsp;
            </span>

            <?php if (empty($noticia->objDenuncioComentarioUsuario)): ?>
            &nbsp; <?php
            echo Html::a('Denunciar', '#', [
            //'id' => 'showFormPublications' . $linea->idLineaTiempo,
            'data-role' => 'denunciar-contenido',
            'data-contenido' => $noticia->idContenido,
            'data-linea-tiempo' => $noticia->idLineaTiempo,
            'onclick' => 'return false'
            ])
            ?>  &nbsp;
            <?php else: ?>
            &nbsp;&nbsp;Ya denunciaste
            <?php endif; ?>
          </li>
        </ul>
        <!--<div class="clearfix"></div>-->
      <!--</div>-->
        <div class="clearfix"></div>
        <textarea id="comentario_<?= $noticia->idContenido ?>" placeholder="Comentar Publicación..." class="form-control" rows="2"></textarea>
        <?php
        echo \vova07\imperavi\Widget::widget([
        'selector' => '#comentario_' . $noticia->idContenido,

        'settings' => [
        'buttons' => ['format', 'bold', 'italic'],
        'lang' => 'es',
        'minHeight' => 80,
        'imageManagerJson' => Url::to(['/default/images-get']),
        'plugins' => [
          'imagemanager'
        ]
        ]
        ]);
        ?>
        <button class="btn btn-primary btn-xs comentar" data-role='guardar-comentario-contenido' data-contenido='<?= $noticia->idContenido ?>' value="" type="button"><i class="fa fa-pencil"></i>
        Comentar
        </button>
        <div class="clearfix"></div>
        <?php else: ?>
        <button type="button" class="btn btn-white btn-xs btn-mini" data-clasificado = "<?= $noticia->idContenido ?>" data-role="widget-enviarAmigo">Enviar a un amigo</button>
        <?php endif; ?>
    </div>
  </li>
</ul>
