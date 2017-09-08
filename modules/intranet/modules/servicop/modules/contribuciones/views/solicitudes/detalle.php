<?php 

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

$idEstados = ArrayHelper::map($estados, 'idEstadoSolicitud', 'nombreEstado');
?>

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

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        <table id="solicitudes-list" class="table table-hover table-condensed dataTable">
            <thead>
                <tr>
                    <th>Contribución</th>
                    <th>Beneficiario</th>
                    <th>Valor</th>
                    <th>Estado</th>
                    <th>Fecha de solicitud</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><?php echo $solicitud['nombreContribucion']; ?></td>
                    <td><?php echo $solicitud['NombreParentesco']; ?></td>
                    <td><?php echo $solicitud['valorContribucion']; ?></td>
                    <td>
                    <?php 
                        echo $idEstados[$solicitud['idEstadoSolicitud']];
                    ?>
                    </td>
                    <td><?php echo $solicitud['fechaSolicitud']; ?></td>
                </tr>
            </tbody>
        </table>
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
                         echo $idEstados[$solicitud['idEstadoSolicitud']];
                    ?>
                </span>
                <br>
            <?php endforeach ?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="settings" data-role="widgetDocumentosSolicitudContribucion">
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
    </div>
</div>
<?php if (in_array($solicitud['idEstadoSolicitud'], [1,4])): ?>
    <button data-role="radicar-contribucion" data-id-solicitud="<?php echo $solicitud['idSolicitudContribucion'] ?>" class="btn btn-primary">Radicar</button>
<?php endif ?>


<div class="row">
    <div class="col-md-12">
        <div id="widget-documentos-contribucion">
            
        </div>
    </div>
</div>