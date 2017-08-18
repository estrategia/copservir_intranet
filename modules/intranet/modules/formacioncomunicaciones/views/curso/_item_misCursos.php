<?php 
    use yii\helpers\Url;
?>
 <!-- <div class="col-md-12"> -->
        <a style="width: 100%" href="<?= Url::toRoute(['visualizar-curso', 'id' => $model->idCurso]) ?>">
    <p class="titulo-miscursos">
            <?= $model->nombreCurso ?>
    </p>
        </a>
<!-- </div> -->