
  <ul class="list-group">
      <?php foreach ($model->contactos as $contacto): ?>
        <li class="list-group-item">
          <?= $contacto->usuario->nombres . ' ' . $contacto->usuario->primerApellido ?>
            <span style="float: right;">
              <a href="#" data-role="eliminar-contacto-categoria" data-id-categoria="<?= $contacto->idCategoriaPremio ?>" data-numero-documento="<?= $contacto->numeroDocumento ?>">Eliminar contacto <span class="glyphicon glyphicon-trash"></span></a>      
            </span>
        </li>
      <?php endforeach ?>
  </ul>