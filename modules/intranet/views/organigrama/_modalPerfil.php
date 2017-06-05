<div id="modal-perfil" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <img src="<?= Yii::getAlias('@web').'/img/fotosperfil/123456.jpg' ?>" alt="" class="img-circle">
        <h4 class="text-center"></span><?= $usuario['CentroCosto'] ?></h4>
        <h4 class="text-center"><?= $usuario['Nombres'] . ' ' . $usuario['PrimerApellido'] . ' ' . $usuario['SegundoApellido']?></h4>
        <p class="text-center"><?= $usuario['Cargo'] ?></p>
        <p class="text-center"><?= $usuario['Email'] ?></p>
      </div>
  </div>
</div>