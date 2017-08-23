<?php 
    use yii\helpers\Url;
?>
 <!-- <div class="col-md-12"> -->
        <a style="width: 100%" href="<?= Url::toRoute(['visualizar-contenido', 'id' => $model->idContenido]) ?>">
            <p class="titulo-miscursos">
                <?= $model->tituloContenido ?>
            </p>
        </a>
<!-- </div> -->
