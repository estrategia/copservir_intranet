<?php 

$this->title = $solicitud['nombreCredito'];
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h3>Solicitud y Documentación de Crédito</h3>

<ul class="nav nav-tabs" role="tablist" style="background-color: white;">
    <li role="presentation" class="active" style="background-color: mediumaquamarine">
        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Solicitud</a>
    </li>
    <li role="presentation" style="background-color: lightsalmon">
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
                            <th>Modalidad de Credito</th>
                            <td align="right"> <?= $solicitud['nombreCredito'] ?></td>
                        </tr>
                        <tr>
                            <th>Valor solicitado</th>
                            <td align="right">$<?= Yii::$app->formatter->asDecimal($solicitud['valorSolicitud'], 0) ?></td>
                        </tr>
                        <tr>
                            <th>Plazo solicitado</th>
                            <td align="right"><?= $solicitud['plazo'] ?></td>
                        </tr>
                        <tr>
                            <th>Interés Mensual</th>
                            <td align="right"><?= $solicitud['porcentajeIntereses'] ?> %</td>
                        </tr>
                        <tr>
                           <th>Valor Cuota Quincenal</th> 
                           <td align="right">$<?= Yii::$app->formatter->asDecimal($solicitud['valorCuota'], 0) ?></td>
                        </tr>
                        <tr>
                            <th>Nivel de endeudamiento</th>
                            <td align="right"><?= Yii::$app->formatter->asDecimal($relaciones['nivelEndeudamiento'], 2) ?>%</td>
                        </tr>
                        <tr>
                            <th>Fecha</th>
                            <td align="right"><?= $solicitud['fechaCreacion'] ?></td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td align="right"><?php echo Yii::$app->params['servicop']['estados']['solicitudes'][$solicitud['estado']] ?></td>
                        </tr>
                        <?php if ($solicitud['estado'] == 3): ?>
                        <tr>
                            <th>Consecutivo Radicado</th>
                            <td align="right"><?= $solicitud['idSolicitud'] ?></td>
                        </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <?php if ($solicitud['estado'] != 1 && !empty($relaciones['observaciones'])): ?>
                    <h4 class="text-center">Observaciones</h4>
                    <ol>
                    <?php foreach ($relaciones['observaciones'] as $key => $observacion): ?>
                        <li>
                            <?php echo $observacion['fechaRegistro'] ?> -
                            <?php echo $observacion['apellidosNombres'] ?> 
                            <br>
                            <?php echo $observacion['observacion'] ?>
                        </li>
                    <?php endforeach ?>
                    </ol>
                <?php endif ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Cuotas Extraordinarias</h4>
                <div class="list-group">
                    <?php foreach ($relaciones['tipoCuotasExtra'] as $key => $tipoCuotaExtra): ?>
                        <div class="list-group-item">
                        <?php echo $tipoCuotaExtra['nombreCuotaExtra']; ?>
                            <ul>
                                <?php foreach ($relaciones['cuotasExtra'][$tipoCuotaExtra['idTipoCuotaExtra']] as $key => $cuotaExtra): ?>
                                    <li>
                                        <?php echo $cuotaExtra['mes'] == 6 ? 'Junio' : 'Diciembre'; ?>  <?php echo $cuotaExtra['anio']; ?> - 
                                        $<?= Yii::$app->formatter->asDecimal($cuotaExtra['valor'], 0) ?>
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

        <?php if (in_array($solicitud['estado'], [1, 4])): ?>
            <p style="color: red">Proceda a cargar los soportes de la solicitud de crédito por la opción
        "Documentos".</p>
        <?php endif ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="settings" >
        <div data-role="widgetDocumentosSolicitudCredito">
                <p>Señor Asociado, en este espacio encontrará los documentos obligatorios y complementarios que se requiere para el trámite de su solicitud de crédito por favor lea detenidamente y atienda los siguientes pasos:</p>
                <h4>Linea de credito: <?= $solicitud['nombreCredito'] ?></h4>
                    <div class="row">
                    <?php if (!empty($relaciones['documentos'])): ?>
                        <h4>Documentos <small>(Solo archivos Pdf)</small></h4>
                    <?php else: ?>
                        <h4>No se requieren documentos</h4>
                    <?php endif ?>
                    </div>
            <div class="panel panel-default">
                <div class="panel-heading">Documentos Obligatorios</div>
                <p><?php echo $relaciones['lineaCredito']['explicacionDocumentosObligatorios'] ?></p>
                <div class="panel-body">
            
                    <table class="table table-striped">
                        <tbody>
                            <?php foreach ($relaciones['documentos'] as $key => $documento): ?>
                                <?php if ($documento['obligatorio'] == 1 && $documento['esGuia'] == 1): ?>
                                    <tr>
                                            
                                        <?php if (in_array($solicitud['estado'], [1, 4])): ?>
                                            <form id="<?php echo $documento['idSolicitudDocumento'] ?>" class="form-inline cargar-documento" enctype="multipart/form-data" method="post" name="documentos">
                                                <input type="hidden" name="idSolitudDocumento" value="<?php echo $documento['idSolicitudDocumento'] ?>">
                                                <input type="hidden" name="nombreDocumento" value="<?php echo $documento['nombreDocumento'] ?>">
                                                <input type="hidden" name="idSolicitud" value="<?php echo $solicitud['idSolicitud'] ?>">
                                                <td width="80%">
                                                    <h4>
                                                        <?php echo $documento['nombreDocumento'] ?>
                                                    </h4>
                                                    <input type="file" class="" accept=".pdf" name="documento" required />
                                                </td>
                                                <td>
                                                    <?php if ($relaciones['rutasFormatos'][$documento['idDocumento']] != null): ?>
                                                        <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-default btn-sm" data-role="descargar-formato-creditos" data-toggle="tooltip" title="Señor usuario al dar clic sobre este botón obtendrá el documento que requiere para su solicitud" data-placement="bottom">Consultar Guía</button>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    
                                                </td>
                                            </form>
                                            <?php endif ?>
                                               
                                            <td>
                                            
                                            </td>
                                    </tr>
                                <?php endif ?>
                                    
                                <?php if ($documento['obligatorio'] == 1 && $documento['esGuia'] == 0): ?>
                                    <tr>
                                            
                                        <?php if (in_array($solicitud['estado'], [1, 4])): ?>
                                            <form id="<?php echo $documento['idSolicitudDocumento'] ?>" class="form-inline cargar-documento" enctype="multipart/form-data" method="post" name="documentos">
                                                <input type="hidden" name="idSolitudDocumento" value="<?php echo $documento['idSolicitudDocumento'] ?>">
                                                <input type="hidden" name="nombreDocumento" value="<?php echo $documento['nombreDocumento'] ?>">
                                                <input type="hidden" name="idSolicitud" value="<?php echo $solicitud['idSolicitud'] ?>">
                                                <td width="80%">
                                                    <h4>
                                                        <?php echo $documento['nombreDocumento'] ?>
                                                    </h4>
                                                    <input type="file" class="" accept=".pdf" name="documento" required />
                                                </td>
                                                <td>
                                                    <?php if ($relaciones['rutasFormatos'][$documento['idDocumento']] != null): ?>
                                                        <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-default btn-sm" data-role="descargar-formato-creditos" data-toggle="tooltip" title="Señor usuario al dar clic sobre este botón obtendrá el documento que requiere para su solicitud" data-placement="bottom">Obtener Formato</button>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if ($documento['solicitarCarga'] == 1): ?>
                                                        <input style="margin: 10px;" type="submit" class="btn btn-default subir-documento" value="Cargar documento" data-toggle="tooltip" title="Señor usuario por este botón podrá realizar el cargue del archivo, ubíquese en la opción de examinar y cargue el archivo en formato pdf" data-placement="bottom"/>
                                                    <?php endif ?>
                                                </td>
                                            </form>
                                            <?php endif ?>

                                            <td>
                                                <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-primary btn-sm <?php echo $documento['rutaDocumento'] != '' ? '' : 'hidden' ?>" data-role="descargar-documento-creditos">Descargar documento</button>
                                            </td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="panel panel-default">
                <div class="panel-heading">Documentos Complementarios</div>
                <p><?php echo $relaciones['lineaCredito']['explicacionDocumentosOpcionales'] ?></p>

                <div class="panel-body">
                    <table class="table table-striped">
                        <tbody>
                            <?php foreach ($relaciones['documentos'] as $key => $documento): ?>

                                <?php if ($documento['obligatorio'] != 1 && $documento['esGuia'] == 1): ?>
                                    <tr>
                                            
                                        <?php if (in_array($solicitud['estado'], [1, 4])): ?>
                                            <form id="<?php echo $documento['idSolicitudDocumento'] ?>" class="form-inline cargar-documento" enctype="multipart/form-data" method="post" name="documentos">
                                                <input type="hidden" name="idSolitudDocumento" value="<?php echo $documento['idSolicitudDocumento'] ?>">
                                                <input type="hidden" name="nombreDocumento" value="<?php echo $documento['nombreDocumento'] ?>">
                                                <input type="hidden" name="idSolicitud" value="<?php echo $solicitud['idSolicitud'] ?>">
                                                <td width="80%">
                                                    <h4>
                                                        <?php echo $documento['nombreDocumento'] ?>
                                                    </h4>
                                                    <input type="file" class="" accept=".pdf" name="documento" required />
                                                </td>
                                                <td>
                                                    <?php if ($relaciones['rutasFormatos'][$documento['idDocumento']] != null): ?>
                                                        <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-default btn-sm" data-role="descargar-formato-creditos" data-toggle="tooltip" title="Señor usuario al dar clic sobre este botón obtendrá el documento que requiere para su solicitud" data-placement="bottom">Consultar Guía</button>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    
                                                </td>
                                            </form>
                                            <?php endif ?>
                                               
                                            <td>
                                            
                                            </td>
                                    </tr>
                                <?php endif ?>
                                    
                                <?php if ($documento['obligatorio'] != 1 && $documento['esGuia'] == 0): ?>
                                    <tr>
                                        <div class="" id="<?php echo $documento['idSolicitudDocumento'] ?>">
                                            
                                        <?php if (in_array($solicitud['estado'], [1, 4])): ?>
                                            <form id="<?php echo $documento['idSolicitudDocumento'] ?>" class="form-inline cargar-documento" enctype="multipart/form-data" method="post" name="documentos">
                                                <input type="hidden" name="idSolitudDocumento" value="<?php echo $documento['idSolicitudDocumento'] ?>">
                                                <input type="hidden" name="nombreDocumento" value="<?php echo $documento['nombreDocumento'] ?>">
                                                <input type="hidden" name="idSolicitud" value="<?php echo $solicitud['idSolicitud'] ?>">
                                                <td width="80%">
                                                    <h4>
                                                        <?php echo $documento['nombreDocumento'] ?>
                                                    </h4>
                                                    <input type="file" class="" accept=".pdf" name="documento" required />
                                                </td>
                                                <td>
                                                    <?php if ($documento['solicitarCarga'] == 1): ?>
                                                        <input style="margin: 10px;" type="submit" class="btn btn-default subir-documento" value="Cargar documento"  data-toggle="tooltip" title="Señor usuario por este botón podrá realizar el cargue del archivo, ubíquese en la opción de examinar y cargue el archivo en formato pdf" data-placement="bottom" />
                                                    <?php endif ?>
                                                </td>
                                            </form>
                                            <?php endif ?>
                                            <td>
                                                <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-primary btn-sm <?php echo $documento['rutaDocumento'] != '' ? '' : 'hidden' ?>" data-role="descargar-documento-creditos">Descargar documento</button>
                                            </td>
                                                
                                        </div>
                                    </tr>
                                <?php endif ?>
                                
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br><br>
        <?php if (in_array($solicitud['estado'], [1, 4])): ?>
            <button data-role="radicar-credito" data-id-solicitud="<?php echo $solicitud['idSolicitud'] ?>" class="btn btn-primary">Confirmar Solicitud</button>
        <?php endif ?>
    </div>
    
  </div>