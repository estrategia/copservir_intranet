<p>Señor Asociado, en este espacio encontrará los documentos básicos y complementarios que se requiere para el trámite de su solicitud de crédito por favor lea detenidamente y atienda los siguientes pasos:</p>
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
                <div class="panel-body">
            
                    <table class="table table-striped">
                        <tbody>
                            <?php foreach ($relaciones['documentos'] as $key => $documento): ?>
                                    
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
                                                    <p><?php echo $documento['descripcionDocumento']; ?></p>
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
                                                <?php if ($documento['rutaDocumento'] != ''): ?>
                                                    <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-primary btn-sm" data-role="descargar-documento-creditos">Descargar documento</button>
                                                <?php endif ?>
                                            </td>
                                    </tr>
                                <?php endif ?>
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
                                                    <p><?php echo $documento['descripcionDocumento']; ?></p>
                                                    <input type="file" class="" accept=".pdf" name="documento" required />
                                                </td>
                                                <td>
                                                    <?php if ($relaciones['rutasFormatos'][$documento['idDocumento']] != null): ?>
                                                        <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-default btn-sm" data-role="descargar-formato-creditos" data-toggle="tooltip" title="Señor usuario al dar clic sobre este botón obtendrá el documento que requiere para su solicitud" data-placement="bottom">Obtener Guía</button>
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
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="panel panel-default">
                <div class="panel-heading">Documentos Opcionales</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tbody>
                            <?php foreach ($relaciones['documentos'] as $key => $documento): ?>
                                    
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
                                                    <?php if (isset($relaciones['rutasFormatos'][$documento['idDocumento']])): ?>
                                                        <?php if ($relaciones['rutasFormatos'][$documento['idDocumento']] != null): ?>
                                                        <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-default btn-sm" data-role="descargar-formato-creditos" data-toggle="tooltip" title="Señor usuario al dar clic sobre este botón obtendrá el documento que requiere para su solicitud" data-placement="bottom">Obtener Formato</button>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if ($documento['solicitarCarga'] == 1): ?>
                                                        <input style="margin: 10px;" type="submit" class="btn btn-default subir-documento" value="Cargar documento"  data-toggle="tooltip" title="Señor usuario por este botón podrá realizar el cargue del archivo, ubíquese en la opción de examinar y cargue el archivo en formato pdf" data-placement="bottom" />
                                                    <?php endif ?>
                                                </td>
                                            </form>
                                            <?php endif ?>
                                            <td>
                                                <?php if ($documento['rutaDocumento'] != ''): ?>
                                                    <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-primary btn-sm" data-role="descargar-documento-creditos">Descargar documento</button>
                                                <?php endif ?>
                                            </td>
                                                
                                        </div>
                                    </tr>
                                <?php endif ?>
                                <?php if ($documento['obligatorio'] == 0 && $documento['esGuia'] == 1): ?>
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
                                                    <p><?php echo $documento['descripcionDocumento']; ?></p>
                                                    <input type="file" class="" accept=".pdf" name="documento" required />
                                                </td>
                                                <td>
                                                    <?php if ($relaciones['rutasFormatos'][$documento['idDocumento']] != null): ?>
                                                        <button style="margin: 10px;" data-id-documento="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-default btn-sm" data-role="descargar-formato-creditos" data-toggle="tooltip" title="Señor usuario al dar clic sobre este botón obtendrá el documento que requiere para su solicitud" data-placement="bottom">Obtener Guía</button>
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
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>