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
                        echo Yii::$app->params['servicop']['estados']['solicitudes'][$traza['estado']];
                    ?>
                </span>
                <br>
            <?php endforeach ?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="settings">
        <div class="row">
            <h4>Documentos <small>(Solo archivos Pdf)</small></h4>
        </div>
        <?php foreach ($relaciones['documentos'] as $key => $documento): ?>
            <div class="row" id="<?php echo $documento['idSolicitudDocumento'] ?>">
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
                <div class="col-md-2">
                    <?php if ($documento['rutaDocumento'] != ''): ?>
                        <label for="">&nbsp;</label>
                        <a id="<?php echo $documento['idSolicitudDocumento'] ?>" class="btn btn-primary" href="<?php echo $documento['rutaDocumento'] ?>" download >Descargar <?php echo $documento['nombreDocumento'] ?></a>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="widget-documentos-contribucion">
            
        </div>
    </div>
</div>