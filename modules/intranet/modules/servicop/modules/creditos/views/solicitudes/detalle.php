<?php 

$this->title = $solicitud['nombreCredito'];
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h3 class="text-center">Línea de crédito</h3>
<h4 class="text-center">
    <?= $solicitud['nombreCredito'] ?>
</h4>


<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Solicitud</a>
    </li>
    <li role="presentation">
        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Observaciones</a>
    </li>
    <li role="presentation">
        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Traza</a>
    </li>
    <li role="presentation">
        <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Documentos</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-stripped">
                    <tbody>
                        <tr>
                            <th>Plazo máximo</th>
                            <td><?= $solicitud['plazoMaximo'] ?></td>
                        </tr>
                        <tr>
                           <th>Valor Cuota Quincenal</th> 
                           <td><?= Yii::$app->formatter->asCurrency($solicitud['valorCuota'], 'COP') ?></td>
                        </tr>
                        <tr>
                            <th>Interés Mensual</th>
                            <td><?= $solicitud['porcentajeIntereses'] ?> %</td>
                        </tr>
                        <tr>
                            <th>Fecha</th>
                            <td><?= $solicitud['fechaCreacion'] ?></td>
                        </tr>
                        <?php if ($solicitud['estado'] == 3): ?>
                        <tr>
                            <th>Consecutivo Radicado</th>
                            <td><?= $solicitud['idSolicitud'] ?></td>
                        </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <div class="jumbotron">
                    <h4>
                        <?php echo Yii::$app->params['servicop']['mensajeSolicitud'] ?>
                    </h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Cuotas Extra</h4>
                <div class="list-group">
                    <?php foreach ($relaciones['tipoCuotasExtra'] as $key => $tipoCuotaExtra): ?>
                        <div class="list-group-item">
                        <?php echo $tipoCuotaExtra['nombreCuotaExtra']; ?>
                            <ul>
                                <?php foreach ($relaciones['cuotasExtra'][$tipoCuotaExtra['idTipoCuotaExtra']] as $key => $cuotaExtra): ?>
                                    <li>
                                        <?php echo $cuotaExtra['mes']; ?>/<?php echo $cuotaExtra['anio']; ?> - 
                                        <?= Yii::$app->formatter->asCurrency($cuotaExtra['valor'], 'COP') ?>
                                    </li>                                 
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-md-6">
                <h4>Garantías</h4>
                <ul>
                    <?php foreach ($relaciones['garantias'] as $key => $tipoCuotaExtra): ?>
                        <li>
                            <?php echo $tipoCuotaExtra['nombreGarantia']; ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
        <div class="row">
            <h4>Observaciones</h4>
            <?php foreach ($relaciones['observaciones'] as $key => $observacion): ?>
                <span>
                    <?php echo $observacion['fechaRegistro'] ?>
                    <?php echo $observacion['observacion'] ?>
                </span><br>
            <?php endforeach ?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="messages">
        <div class="row">
            <h4>Traza</h4>
            <?php foreach ($relaciones['traza'] as $key => $traza): ?>
                <span>
                    <?php echo $traza['fechaRegistro'] ?>
                    <?php 
                        echo Yii::$app->params['servicop']['estados']['solicitudes'][$traza['estado']];
                    ?>
                </span>
                <br>
            <?php endforeach ?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="settings" data-role="widgetDocumentosSolicitudCredito">
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
    </div>
    <?php if (in_array($solicitud['estado'], [1, 4])): ?>
        <button data-role="radicar-credito" data-id-solicitud="<?php echo $solicitud['idSolicitud'] ?>" class="btn btn-primary">Confirmar Solicitud</button>
    <?php endif ?>
  </div>