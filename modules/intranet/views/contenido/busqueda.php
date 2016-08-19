<?php

use yii\widgets\ListView;
use yii\helpers\Html;

$this->title = 'Resultado busqueda';
?>
<!--
<div class="tiles white p-t-35 p-r-20 p-b-30 col-sm-12">
  <h2 class='bold text-success'>Resultado de la busqueda</h2>
  <hr>
  <div class="app_timeline text-center">
    <img class="archivo-timeline" usemap="#archivo-timeline" src="<?php //$url['url'] ?>" alt="Línea de tiempo">
    contenedor de la imagen mapeada
    <div class="map-img"></div>
  </div>
</div>
  -->
<!-- lista de noticias encontradas  -->
<?php
/*
ListView::widget([
  'dataProvider' => $resultados,
  'options' => [
    'tag' => 'div',
    'class' => 'list-wrapper',
    'id' => 'list-wrapper',
  ],
  'layout' => "{summary}\n{items}\n<div class='col-md-4 col-md-offset-8'>{pager}</div>",
  'itemView' => function ($model, $var, $index, $widget) {
    return $this->render('_contenido', ['noticia' => $model]);
  },
  'itemOptions' => [
    'tag' => false,
  ],
  'pager' => [
    'firstPageLabel' => 'Inicio',
    'lastPageLabel' => 'Fin',
    'nextPageLabel' => 'Siguiente',
    'prevPageLabel' => 'Anterior',
    'maxButtonCount' => 5,
  ],
]);
*/
?>

<?php
/*
$this->registerJs(
"
//::::::::::::::::::::::
// MAPEO DE LA IMAGEN
//::::::::::::::::::::::

//Ajax con peticion para generar el mapeo de la imagen

$( document ).ready(function() {


  $.ajax({
    type: 'GET',
    async: true,
    url: ".$url['urlJson'].",
    dataType: 'json',
    beforeSend: function() {
      //    Loading.show();
      $('#map-img').remove();
    },

    complete: function(data) {
      //   Loading.hide();
    },
    success: function(data) {
      console.log('succes');
      console.log(data);
      makeMap(data, '$patron', $valorGrafica, '$flag')
    },
    error: function(jqXHR, textStatus, errorThrown) {

    }
  })
});
"
);
*/
?>
<!-- NUEVO BUSCADOR -->

<div class="col-md-12">
<?php

 $items = explode("<br />", $resultados);

?>
<h3><?=  Html::encode('resultados para: '.$patron) ?></h3>

<?php if (strstr($items[0], 'Tal vez quiso decir ') !== false): ?>
    <?php $items = array_slice($items, 1); ?>
<?php endif; ?>

<?php foreach ($items as $item): ?>
  <?php if (!empty($item)): ?>
  <?php $itemDividido = explode("-_-", $item); ?>
  <?php
    $icono = 'fa fa-comments';
    $color = 'primary'; //success info
    $posDocumento = strstr($itemDividido[0], 'Tipo: <b>DOCUMENTO</b>');
    $posArchivo = strstr($itemDividido[0], 'Tipo: <b>ARCHIVO</b>');

    if ($posDocumento !== false) {
      $color = 'success';
      $icono = 'glyphicon glyphicon-book';
    }

    if ($posArchivo !== false){
      $color = 'info';
      $icono = 'fa fa-file';
    }
   ?>
  <ul class="cbp_tmtimeline">
    <li>
      <div class="cbp_tmtime">
      </div>
      <div class="cbp_tmicon <?= $color ?> animated bounceIn"> <i class="<?= $icono ?>"></i> </div>
      <div class="cbp_tmlabel">
        <div class="p-t-10 p-l-30 p-r-20 p-b-20 xs-p-r-10 xs-p-l-10 xs-p-t-5">
          <?=  $itemDividido[0] ?>
          <p class="m-t-5 dark-text">
            <?php  if (count($itemDividido)>1): ?>
              <?php
                $pos = strpos($itemDividido[1], '...');
               ?>
              <?php  if ($pos === false): ?>
                <p>
                  No se puede obtener fragmento de busqueda
                </p>
              <?php else: ?>
                <?=  $itemDividido[1] ?>
              <?php endif; ?>
            <?php endif; ?>
          </p>
        </div>
      </div>
    </li>
  </ul>
  <?php  endif; ?>
<?php  endforeach; ?>
</div>
