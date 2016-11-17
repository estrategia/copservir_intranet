<?php
  use yii\web\View;
  $this->registerJsFile('@web/js/tradeMarketing/trademarketing.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
  // CVarDumper::dump($informacionReporte, 10 ,true); exit();
  $asignacion = $informacionReporte['asignacion'];
  $categorias = $informacionReporte['categorias'];
?>
<div class="col-md-12">
  <div class="table-responsive">
    <table class="table table-bordered table-hover table-condensed">
      <tbody>
        <tr>
          <th>Punto de venta:</th>
          <td> <?php echo $asignacion['idComercial']; ?> </td>
          <th>Fecha:</th>
          <td> <?php echo date("d M Y", strtotime($asignacion['fechaAsignacion'])); ?> </td>
        </tr>
        <tr>
          <th>Admin - SubAdmin</th>
          <td> <?php echo $asignacion['administrador']['nombres'] . '-' . $asignacion['subAdministrador']['nombres']; ?> </td>
          <th># De chequeo</th>
          <td> <?php echo $asignacion['idAsignacion']; ?> </td>
        </tr>
        <tr>
          <th>Supervisado por:</th>
          <td> <?php echo $asignacion['usuarioSupervisor']; ?> </td>
          <th>Formato:</th>
          <td> <?php echo $asignacion['nombreTipoNegocio']; ?> </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered table-hover table-condensed ">
      <thead>
        <tr>
          <th rowspan="2">Unidades de negocio</th>
          <th rowspan="2">Variables</th>
          <th>Unidad RX</th>
          <th>OTC</th>
          <th>Cuidado personal</th>
          <th>Alimentos y bebidas</th>
          <th>Aseo y hogar</th>
          <th rowspan="2">Total</th>
          <th rowspan="2">Observacion</th>
        </tr>
        <tr>
          <th colspan="5">M:2 R:3 B:4 E:5</th>
        </tr>
      </thead>
      <tbody>
        
        <?php $cantidadVariables = 0 ?>
        <?php foreach($categorias as $categoria): ?>
          <?php $cantidadVariables = count($categoria['variables']) ?>
            <tr>
              <td rowspan=" <?php echo $cantidadVariables + 1; ?>" >
                <?php echo $categoria['nombreCategoria']; ?>
              </td>
                
              <?php foreach($categoria['variables'] as $indiceVariable => $variable): ?>
                <tr>
                  <td>
                    <?php echo $variable['nombreVariable'] ?>
                  </td>
                  <?php foreach($variable['calificaciones'] as $key => $calificacion): ?>
                    <?php if($key == ""): ?>
                      <td colspan="5">
                        <?php echo $calificacion['calificacion']; ?>
                      </td>
                    <?php else: ?>
                      <td>
                        <?php echo $calificacion['calificacion']; ?>
                      </td>                
                    <?php endif; ?>
                  <?php endforeach; ?>
                  <td>
                    <?php echo $categoria['promediosVariables'][$indiceVariable]; ?>
                  </td>
                  <td>
                    <button class="btn btn-default btn-xs" data-asignacion="<?php echo $asignacion['idAsignacion']; ?>" data-variable="<?php echo $indiceVariable; ?>" data-accion="ver-observaciones">Ver</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    
        <?php foreach($categorias as $categoria): ?>
          <tr>
            <th colspan="2">
              <?php echo $categoria['nombreCategoria']; ?>
            </th>
            <?php foreach($categoria['promediosUnidadesNegocio'] as $key => $promedio): ?>
              <?php if($key == ""): ?>
                <td colspan="5">
                  <?php echo Yii::$app->formatter->asDecimal($promedio, 3); ?>
                </td>
              <?php else: ?>
                <td>
                  <?php echo Yii::$app->formatter->asDecimal($promedio, 3); ?>
                </td>
              <?php endif; ?>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<style>
  table {
    /*table-layout: fixed;*/
  }
  table * {
    text-align: center;
  }
  th {
    vertical-align: middle!important;
  }
</style>