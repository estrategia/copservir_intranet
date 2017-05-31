<h3 class="titulo-columna-cursos formacion">Formación</h3>
<div class="listado-cursos-contenedor">
    <div class="listado-cursos-todos">
        <?php foreach ($cursosFormacion as $key => $curso): ?>
            <div class="listado-cursos-item">
              <img class="" src="<?= \Yii::getAlias('@web') . '/formacioncomunicaciones/cursos/' . $curso->rutaImagen ?>" >
              <div class="listado-cursos-item-titulo">
                <h3 class=""><?= $curso->nombreCurso ?></h3>
              </div>
            </div>
        <?php endforeach ?>
      </div>
</div>