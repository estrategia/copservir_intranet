<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Resultado busqueda';
?>

<div class="app_timeline">

                <img class="archivo-timeline" usemap="#archivo-timeline" src="<?= $url['url'] ?>" alt="Línea de tiempo">

                <!-- contenedor de la imagen mapeada -->
                <div class="map-img">
                </div>
</div>
<!-- lista de noticias encontradas  -->
<?=
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
?>

<?php
$this->registerJs(
        "
  //::::::::::::::::::::::
  // MAPEO DE LA IMAGEN
  //::::::::::::::::::::::

  /*
  * Ajax con peticion para generar el mapeo de la imagen
  */
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
?>
