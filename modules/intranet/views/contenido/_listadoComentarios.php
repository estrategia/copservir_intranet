<div class="tiles white ">
  <?php foreach ($comentariosContenido as $comentario): ?>
    <div class="p-t-20 p-b-15 b-b b-grey">
      <div class="post overlap-left-10">
        <div class="user-profile-pic-wrapper">
          <div class="user-profile-pic-2x white-border">
            <div class="user-profile">
              <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $comentario->objUsuarioPublicacionComentario->imagenPerfil ?> alt="" data-src="" data-src-retina="" width="40" height="40">
            </div>

          </div>
        </div>

        <div class="info-wrapper small-width inline">
          <div class="info text-black ">
            <p>
              <strong><?= $comentario->objUsuarioPublicacionComentario->alias ?></strong> <?= $comentario->contenido ?>
            </p>
            <p class="muted small-text">
              <?php  if (isset($comentario->fechaComentario)): ?>
                <?php $fdia = \DateTime::createFromFormat('Y-m-d H:i:s', $comentario->fechaComentario) ?>
                <?= Yii::$app->params['calendario']['dias'][$fdia->format('w')] ?>
                <?= $fdia->format('j') ?> <?= Yii::$app->params['calendario']['meses'][$fdia->format('n')] ?> <?= $fdia->format('Y') ?>
                <?= $fdia->format('h:i:s a') ?>

              <?php endif; ?>
            </p>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="inline pull-right">
          <?php if ($comentario->numeroDocumento == Yii::$app->user->identity->numeroDocumento): ?>
            <a href='#' data-comentario= "<?= $comentario->idContenidoComentario ?>"  data-role='eliminar-comentario' title='Eliminar comentario'>
              <li class="fa fa-times fa-lg"></li>
            </a> &nbsp;
          <?php elseif (empty($comentario->objDenuncioComentarioUsuario)): ?>
            <a href='#' data-comentario= "<?= $comentario->idContenidoComentario ?>"  data-role='denunciar-comentario' title='Denunciar comentario'>
              <i class="fa fa-exclamation-triangle fa-lg"></i>
            </a>
          <?php else: ?>
            <li class="fa fa-info-circle fa-lg" title='Ya has denunciado esto'></li>
          <?php endif; ?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>


  <?php endforeach; ?>
</div>
