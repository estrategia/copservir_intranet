<?php foreach ($comentariosContenido as $comentario): ?>
    <div class="row">
        <div class="col-md-2">
            <div class="user-profile">
                <img src= <?= Yii::$app->homeUrl . 'img/fotosperfil/' . $comentario->objUsuarioPublicacionComentario->imagenPerfil ?> alt="" data-src="" data-src-retina="" width="40" height="40">
            </div>
            <?= $comentario->objUsuarioPublicacionComentario->alias ?>
        </div>
        <div class="col-md-9">

            <?= $comentario->contenido ?>
        </div>
        <div class="col-md-1">
            <!-- Botones de denunciar y/o eliminar -->
            <?php if ($comentario->idUsuarioComentario == Yii::$app->user->identity->numeroDocumento): ?>
                <a href='#' data-comentario= "<?= $comentario->idContenidoComentario ?>"  data-role='eliminar-comentario' title='Eliminar comentario'>
                    <li class="fa fa-times"></li>
                </a> &nbsp;
            <?php elseif (empty($comentario->objDenuncioComentarioUsuario)): ?>
                <a href='#' data-comentario= "<?= $comentario->idContenidoComentario ?>"  data-role='denunciar-comentario' title='Denunciar comentario'>
                    <li class="fa fa-bullhorn"></li>
                </a>
            <?php else: ?>
                    <li class="fa fa-info-circle" title='Ya has denunciado esto'></li>
            <?php endif; ?>
        </div>
    </div>  
<?php endforeach; ?>