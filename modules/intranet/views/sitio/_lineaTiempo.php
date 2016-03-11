<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<!-- las noticias -->
<?= Html::button('<i class="fa fa-pencil"></i> Publicar <i><small>Requiere Aprobación</small></i>', [
      'id' => 'showFormPublications'.$linea->idLineaTiempo,
      'class' => 'btn btn-primary btn-lg btn-large',
      'data-role'=>'showFormPublications',
      'value'=>Url::to(['sitio/form-noticia', 'lineaTiempo'=>$linea->idLineaTiempo])
  ]); ?>

<?php foreach($noticias as $noticia):?>


    <ul class="cbp_tmtimeline">
      <li>
        <time class="cbp_tmtime"></time>
        <span class="date">Hoy</span> <!-- falta acomodar el formato de la fecha -->
        <span class="time"><?= $noticia->fechaInicioPublicacion?> <span class="semi-bold">am</span></span>

        <div class="cbp_tmicon primary animated bounceIn"> <i class="fa fa-comments"></i> </div> <!-- icono de la noticia -->

        <div class="cbp_tmlabel">
            <div class="p-t-10 p-l-30 p-r-20 p-b-20 xs-p-r-10 xs-p-l-10 xs-p-t-5">
              <h4 class="inline m-b-5"><span class="text-success semi-bold"><?= $noticia->titulo?></span> </h4>
              <h5 class="inline muted semi-bold m-b-5"></h5> <!-- para el usuario que publico la noticia -->
              <!--<div class="muted">Publicación Compartida - 12:45pm</div> si la publicacion fue compartida-->
              <p class="m-t-5 dark-text">
                 <?= $noticia->contenido?>
               </p>
            </div>

            <!-- comentarios y me gusta -->
            <?php if($linea->tipo === 0): ?>

                <textarea id="text-editor" placeholder="Comentar Publicación..." class="form-control" rows="2"></textarea>
                <div class="clearfix"></div>
                <div class="tiles grey p-t-10 p-b-10 p-l-20">
                  <ul class="action-links">
                    <li>124 Me Gusta</li>
                    <li>5 Comentarios</li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
            <?php else: ?>
              <button type="button" class="btn btn-white btn-xs btn-mini">Enviar a un amigo</button>
            <?php endif; ?>
          </div>
        </li>
      </ul>

<?php endforeach; ?>

<?php
        $this->registerJs(
            " //aria-expanded='true'

            $(document).on('click', '#showFormPublications".$linea->idLineaTiempo."', (function() {

                console.log('dio click')
                $('#modal').modal('show').find('#modal-content').load($(this).attr('value'));
                console.log($('#modal').modal('show').find('#modal-content').load($(this).attr('value')))
              }));
              "
        );
    ?>
