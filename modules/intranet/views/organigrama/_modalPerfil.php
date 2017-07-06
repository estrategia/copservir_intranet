<div id="modal-perfil" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <?php if (!is_null($usuario) && !empty($usuario)): ?>
          <img src="<?= $imagen ?>" alt="" class="img-circle">
          <h4 class="text-center"><?= $usuario['CentroCosto'] ?></h4>
          <h4 class="text-center"><?= $usuario['Nombres'] . ' ' . $usuario['PrimerApellido'] . ' ' . $usuario['SegundoApellido']?></h4>
          <p class="text-center"><?= $usuario['Cargo'] ?></p>
          <p class="text-center"><?= $usuario['Email'] ?></p>
        <?php else: ?>
          <h4 class="text-center">Sin información del usuario</h4>
        <?php endif ?>
      </div>
  </div>
</div>