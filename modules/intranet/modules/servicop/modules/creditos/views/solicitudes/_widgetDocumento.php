<div class="row">
    <h4>Documentos <small>(Solo archivos Pdf)</small></h4>
</div>
<?php foreach ($relaciones['documentos'] as $key => $documento): ?>
    <div class="row" id="<?php echo $documento['idSolicitudDocumento'] ?>">
        <?php if (in_array($solicitud['estado'], [1, 4])): ?>
            
        <div class="col-md-6 col-md-offset-2">
            
        <form id="<?php echo $documento['idSolicitudDocumento'] ?>" class="form-inline cargar-documento" enctype="multipart/form-data" method="post" name="documentos">
            <input type="hidden" name="idSolitudDocumento" value="<?php echo $documento['idSolicitudDocumento'] ?>">
            <input type="hidden" name="nombreDocumento" value="<?php echo $documento['nombreDocumento'] ?>">
            <input type="hidden" name="idSolicitud" value="<?php echo $solicitud['idSolicitud'] ?>">
            <div class="form-group">
                <label><?php echo $documento['nombreDocumento'] ?></label>
                <input type="file" class="form-control" accept=".pdf" name="documento" required />
                <input type="submit" class="btn btn-default subir-documento" value="Cargar documento" />
            </div>
        </form>
        </div>
        <?php endif ?>
        <div class="col-md-2">
            <?php if ($documento['rutaDocumento'] != ''): ?>
                <label for="">&nbsp;</label>
                <a id="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-primary" href="<?php echo $documento['rutaDocumento'] ?>" download >Descargar <?php echo $documento['nombreDocumento'] ?></a>
            <?php endif ?>
        </div>
    </div>
<?php endforeach ?>