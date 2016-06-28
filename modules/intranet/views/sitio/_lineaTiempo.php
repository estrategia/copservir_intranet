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
<!-- las noticias -->

<?php if ($linea->tipo != LineaTiempo::TIPO_ANIVERSARIO): ?>
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

    </div>
    <div class="col-md-6">
        <?=
        ($linea->autorizacionAutomatica == 0) ? Html::a('Ver Noticas Copservir', ['contenido/noticias', 'lineaTiempo' => $linea->idLineaTiempo], [
                    'class' => 'btn btn-block btn-warning',
                ]) : '';
        ?>
    </div>
</div>
