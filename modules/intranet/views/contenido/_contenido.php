<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\intranet\models\LineaTiempo;

$completo = isset($completo) ? $completo : false;
?>

<style media="screen">
  .title-notice:hover{
    text-decoration:underline;
    color: #0aaec2;
  }
</style>
<ul class="cbp_tmtimeline">
    <li>
        <div class="cbp_tmtime">
            <div class="user-profile text-center">
                <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $noticia->objUsuarioPublicacion->getImagenPerfil() ?>
                alt="" data-src="" data-src-retina="" width="80" height="80">
            </div>
            <div class="text-center time">  </div>
        </div>

        <div class="cbp_tmicon primary animated bounceIn"> <i class="fa fa-comments"></i> </div>

        <div class="cbp_tmlabel">
            <div class="">

                <h5 class="inline semi-bold m-b-5"><?= $noticia->objUsuarioPublicacion->alias ?></h5>
                <div class="muted">

                  <?php if (isset($noticia->fechaInicioPublicacion)): ?>

                      <?php
                        $fdia = \DateTime::createFromFormat('Y-m-d H:i:s', $noticia->fechaInicioPublicacion);
                        $dia = Yii::$app->params['calendario']['dias'][$fdia->format('w')];
                        $numero = $fdia->format('j');
                        $mes = Yii::$app->params['calendario']['mesesAbreviado'][$fdia->format('n')];
                        $anio = $fdia->format('Y');
                        $horas = $fdia->format('h:i a');
                      ?>

                      <div class="date"> <?= $dia.' '.$numero.' '.$mes.' '.$anio.' '.$horas  ?></div>

                  <?php endif; ?>

                </div>
                <div class="m-l-10 m-r-10 xs-m-l-5 xs-m-r-5">
                  <!-- Titulo noticia -->
                  <?= Html::a('<h3 class=" title-notice inline m-b-5"><span class="text-success semi-bold"> ' . $noticia->titulo.'</h3> ',
                    ['contenido/detalle-contenido', 'idNoticia' => $noticia->idContenido], ['class' => '']) ?>

                  <!-- Contenido noticia -->
                  <div style="<?= $completo ? "": "max-height: 150px; text-overflow:ellipsis; overflow:hidden;margin-bottom: 25px;"?>">
                      <?= $noticia->contenido ?>
                  </div>

                  <!-- IMAGENES -->
                  <?php if (!empty($noticia->objContenidoAdjuntoImagenes)): ?>
                      <?php $contador = 0; ?>
                      <div class="row">
                      <?php foreach ($noticia->objContenidoAdjuntoImagenes as $imagenes): ?>
                          <?php
                          $contador++;
                          $style = '';
                          $mensaje = '';
                          if ($contador > \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) {
                              $style = 'display:none';
                          }

                          if ($contador == \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) {
                              if (($contador) != count($noticia->objContenidoAdjuntoImagenes)) {
                                  $mensaje = (count($noticia->objContenidoAdjuntoImagenes) - \Yii::$app->params['imagenesNoticias']['limiteVisualizar']) . '+'; // cambiar por una constante
                              }
                          }
                          ?>
                        
                          <div class="col-md-4 col-sm-4">
                          <a class="lightbox gallery<?= $noticia->idContenido ?>" href="<?= Yii::getAlias('@web') . "/img/imagenesContenidos/" . $imagenes->rutaArchivo ?>" style="<?= $style ?>">

                                  <div class="slide-front ha slide">
                                      <div class="overlayer bottom-left fullwidth">
                                          <div class="overlayer-wrapper">
                                              <div class="p-l-20 p-r-20 p-b-20 p-t-20" style="text-align:center;">
                                                  <h1 style="color:#fff !important;line-height:37px;background-color: rgba(0, 0, 0, 0.17)"><span class="semi-bold"><?= $mensaje ?></span></h1>
                                              </div>
                                          </div>
                                      </div>
                                      <img src="<?= Yii::getAlias('@web') . "/img/imagenesContenidos/" . $imagenes->rutaArchivo ?>" class="img-thumbnail"/>
                                  </div>

                          </a>
                          </div>
                      <?php endforeach; ?>
                          </div>
                      <?php $this->registerJs("jQuery('.gallery$noticia->idContenido').lightbox();");?>
                      <script type="text/javascript">
                        jQuery('.lightbox').lightbox();
                      </script>
                  <?php endif; ?>

                </div>
            </div>


            <!-- comentarios y me gusta -->

            <?php if ($noticia->objLineaTiempo->tipo == LineaTiempo::TIPO_PUBLICACION || $noticia->objLineaTiempo->tipo == LineaTiempo::TIPO_ANIVERSARIO): ?>
                <ul class="action-links post b-grey grey col-md-12 col-sm-12 col-xs-12" >
                    <li style="width:100%; padding:10px; border: 1px solid #eee;">
                        <?php $noExisteMeGusta = (empty($noticia->listMeGustaUsuario) || count($noticia->listMeGustaUsuario) < 1) ?>

                        <a id='megusta_<?= $noticia->idContenido ?>' class="" data-role='me-gusta-contenido' data-contenido='<?= $noticia->idContenido ?>' data-value='1' style='font-weight: bold;cursor:pointer; cursor: hand ;display: <?= $noExisteMeGusta ? '' : 'none' ?>'>
                            <span class="glyphicon glyphicon-thumbs-up"></span> Me gusta</a>

                        <a id='no_megusta_<?= $noticia->idContenido ?>' class="" data-role='me-gusta-contenido' data-contenido='<?= $noticia->idContenido ?>' data-value='0' style='font-weight: bold;cursor:pointer; cursor: hand ;display: <?= $noExisteMeGusta ? 'none' : '' ?>'>
                            <span class="glyphicon glyphicon-thumbs-down"></span> Ya no me gusta</a>

                        <?php if (empty($noticia->objDenuncioComentarioUsuario)): ?>
                            &nbsp; <?php
                            echo Html::a('<span class="fa fa-exclamation-circle" aria-hidden="true"></span> Denunciar', '#', [
                                'data-role' => 'denunciar-contenido',
                                'data-contenido' => $noticia->idContenido,
                                'data-linea-tiempo' => $noticia->idLineaTiempo,
                                'onclick' => 'return false',
                                'style' => 'font-weight: bold;'
                            ])
                            ?>  &nbsp;
                        <?php else: ?>
                            &nbsp;&nbsp;Ya denunciaste
                        <?php endif; ?>

                        <!-- # de megusta  -->
                        <?php if (count($noticia->listMeGusta) > 0): ?>
                            <span class="badge badge-info pull-right"  id='numero-megusta_<?= $noticia->idContenido ?>'>
                                <?=
                                Html::a(count($noticia->listMeGusta) . " <span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>", '#', [
                                    'data-role' => 'listado-me-gusta-contenido',
                                    'data-contenido' => $noticia->idContenido,
                                    'onclick' => 'return false',
                                    'style' => 'color:white;'
                                ]);
                                ?>
                            </span>
                        <?php endif; ?>

                        <!-- # de comentarios -->
                        <?php if (count($noticia->listComentarios) > 0): ?>
                            <span class="badge badge-info pull-right" style="margin-right: 5px;" id='numero-comentarios_<?= $noticia->idContenido ?>'>
                                <?=
                                Html::a(count($noticia->listComentarios) . " <span class='glyphicon glyphicon-comment' aria-hidden='true'></span>", '#', [
                                    'id' => 'numeroComentarios',
                                    'data-role' => 'listado-comentarios-contenido',
                                    'data-contenido' => $noticia->idContenido,
                                    'onclick' => 'return false',
                                    'style' => 'color:white;'
                                ])
                                ?>
                            </span>
                        <?php endif; ?>
                    </li>
                </ul>
                
                    <div class="col-lg-2 col-md-2 col-xs-12">
                        <img class="profile img-responsive" src=<?= Yii::$app->homeUrl . 'img/fotosperfil/' . $noticia->objUsuarioPublicacion->getImagenPerfil() ?> alt="" data-src="" data-src-retina="" width="60" height="60">
                    </div>
                    <div class="col-lg-10 col-md-10 col-xs-12 ">
                        <textarea class="input-group transparent" id="comentario_<?= $noticia->idContenido ?>" placeholder="Comentar Publicación..." class="form-control" rows="2">
                        </textarea>
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
                    </div>
                
                <div class="clearfix"></div>

                <br>
                <button class="btn btn-primary btn-small" data-role='guardar-comentario-contenido' data-contenido='<?= $noticia->idContenido ?>' value="" type="button"><i class="fa fa-pencil"></i>
                    Comentar
                </button>
                <div class="clearfix"></div>
            <?php elseif($noticia->objLineaTiempo->tipo == LineaTiempo::TIPO_CLASIFICADO): ?>
                <button type="button" class="btn btn-white btn-xs btn-mini" data-clasificado = "<?= $noticia->idContenido ?>" data-role="widget-enviarAmigo">Enviar a un amigo</button>
            <?php endif; ?>
        </div>
    </li>
</ul>
