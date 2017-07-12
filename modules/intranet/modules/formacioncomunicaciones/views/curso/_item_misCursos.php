<?php 
    use yii\helpers\Url;
?>
 <!-- <div class="col-md-12"> -->
    <h3 class="titulo-miscursos">
        <a href="<?= Url::toRoute(['visualizar-curso', 'id' => $model->idCurso]) ?>">
            <?= $model->nombreCurso ?>
        </a>
    </h3>
<!-- </div> -->