<div class="row">
    <h4>Documentos <small>(Solo archivos Pdf)</small></h4>
</div>
<?php // \yii\helpers\VarDumper::dump($relaciones['documentos'],10,true); ?>
<?php foreach ($relaciones['documentos'] as $key => $documento): ?>
    <div class="row" id="<?php echo $documento['idSolicitudDocumento'] ?>">
        <div class="col-md-12">
            <?php if (in_array($solicitud['idEstadoSolicitud'], [1,4])): ?>
                
                <form id="<?php echo $documento['idSolicitudDocumento'] ?>" class="form-inline cargar-documento-contribuciones" enctype="multipart/form-data" method="post" name="documentos">
                    <input type="hidden" name="idSolitudDocumento" value="<?php echo $documento['idSolicitudDocumento'] ?>">
                    <input type="hidden" name="idSolicitudContribucion" value="<?php echo $solicitud['idSolicitudContribucion'] ?>">
                    <input type="hidden" name="nombreDocumento" value="<?php echo $documento['nombreDocumento'] ?>">
                    <h4><?php echo $documento['nombreDocumento'] ?></h4>
                    <div class="form-group">
                        <?php if ($documento['adjuntarDocumento'] == 1): ?>
                            <label>Arhivo</label>
                            <input type="file" class="form-control" accept=".pdf" name="documento" required />
                        <?php endif ?>
                    </div>
                    <?php if ($documento['solicitarValor'] == 1): ?>
                        <div class="form-group">
                            <label for="">Valor</label>
                            <input type="text" class="form-control" name="valor" value="<?php echo $documento['valorDocumento'] ?>" required />
                        </div>
                    <?php endif ?>
                    <?php if ($documento['solicitarFecha'] == 1): ?>
                        <div class="form-group">
                            <label for="">Fecha</label>
                            <!-- <input type="date" class="form-control" name="fecha" required /> -->
                            <?php echo DatePicker::widget([
                                'name' => 'fecha',
                                'type' => DatePicker::TYPE_INPUT,
                                'value' => $documento['fechaDocumento'],
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd'
                                ],
                                'options' => ['required' => true]
                            ]); ?>
                        </div>
                    <?php endif ?>
                    <div class="form-group">
                        <br>
                        <input type="submit" class="btn btn-default subir-documento" value="Cargar documento" />
                    </div>
            <?php endif ?>

                <div class="form-group">
                    <?php if ($documento['rutaArchivo'] != ''): ?>
                        <a id="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-primary" href="<?php echo $documento['rutaArchivo'] ?>" download >Descargar <?php echo $documento['nombreDocumento'] ?></a>
                    <?php endif ?>
                </div>
            </form>
        </div>
    </div>
<?php endforeach ?>