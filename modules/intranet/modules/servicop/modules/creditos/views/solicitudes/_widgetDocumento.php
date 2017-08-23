<?php foreach ($relaciones['documentos'] as $key => $documento): ?>
    <div class="row">
        <form enctype="multipart/form-data" method="post" name="<?php echo $documento['idSolicitudDocumento'] ?>">
          <label><?php echo $documento['nombreDocumento'] ?></label>
          <input type="file" accept=".pdf" name="<?php echo $documento['idSolicitudDocumento'] ?>"/>
          <input type="submit" class="subir-documento" value="Cargar documento!" />
        </form>
    </div>
<?php endforeach ?>