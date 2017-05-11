<?php
use yii\helpers\Html;
use \app\modules\intranet\models\Contenido;
use \app\modules\intranet\models\LineaTiempo;
?>
<?php if (!empty($linea->descripcion)): ?>
    <div class="time-line-description">
        <?= $linea->descripcion ?>
    </div>
<?php endif; ?>

<?php if ($linea->tipo != LineaTiempo::TIPO_ANIVERSARIO && $linea->idLineaTiempo!==1): ?>
    <div class="">
        <a href="#" id="mostrarFormularioContenido" class="btn btn-primary btn-small">
            crea una publicacion
        </a>
    </div>
    <br>
    <div id="publicarContenido" style="display:none">
        <?php
        echo $this->render('/contenido/formContenido', ['objLineaTiempo' => $linea, 'objContenido' => $contenidoModel]);
        ?>
    </div>
<?php endif; ?>


<div class="col-md-12">
    <?php foreach ($noticias as $noticia): ?>
        <span id='contenido_<?= $noticia->idContenido ?>'>
            <?php echo $this->render('/contenido/_contenido', ['noticia' => $noticia, 'linea' => $linea]); ?>
        </span>
    <?php endforeach; ?>
</div>


<div class="row">
    <div class="col-md-6">

      <?= Html::a('Ver todas las publicaciones de mi area', ['contenido/noticias', 'lineaTiempo' => $linea->idLineaTiempo], [
                 'class' => 'btn btn-block btn-warning',
             ])
      ?>
    </div>
    <div class="col-md-6">

      <?= Html::a('Ver todas las publicaciones', ['contenido/todas-noticias', 'lineaTiempo' => $linea->idLineaTiempo], [
                 'class' => 'btn btn-block btn-success',
             ])
      ?>
    </div>
</div>
