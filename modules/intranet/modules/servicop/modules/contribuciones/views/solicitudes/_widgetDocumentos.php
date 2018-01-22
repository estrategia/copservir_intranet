<?php foreach ($documentos as $key => $documento): ?>
    <div class="row">
        <form enctype="multipart/form-data" method="post" name="<?php echo $documento['idContribucionDocumento'] ?>">
            <div class="form-group">
              <label><?php echo $documento['nombreDocumento'] ?></label>
              <input type="file" accept=".pdf" name="<?php echo $documento['idContribucionDocumento'] ?>"/>
              <input type="submit" class="subir-documento" value="Cargar documento!" />
            </div>
        </form>
    </div>
<?php endforeach ?>