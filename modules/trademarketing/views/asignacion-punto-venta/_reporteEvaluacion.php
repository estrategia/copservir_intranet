
<?php 
  $unidadesNegocio = $informacionReporte['reporteEspacios'];
  $espacios = array_values($unidadesNegocio)[0]['espacios'];
  // CVarDumper::dump($unidadesNegocio,10,true);exit();
?>
<div class="col-md-12">
  <div class="table-responsive">
    <table class="table table-bordered table-hover table-condensed ">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <?php foreach($espacios as $espacio): ?>
            <th>
              <?php echo $espacio['porcentaje']; ?>%
            </th>
          <?php endforeach; ?>
          <th>100%</th>
        </tr>
        <tr>
          <th></th>
          <th>PORCENTAJE ESPACIO</th>
          <?php foreach($espacios as $espacio): ?>
            <th>
              <?php echo $espacio['nombre']; ?>
            </th>
          <?php endforeach; ?>
          <th>RESULTADO POR UNIDAD DE NEGOCIO</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($unidadesNegocio as $idUnidad => $unidadNegocio): ?>
          <?php if($idUnidad != ""): ?>
            <tr>
              <td>
                <?php echo $unidadNegocio['nombreUnidadNegocio']; ?>
              </td>
              <td>
                <?php echo $unidadNegocio['porcentajeUnidad']; ?>%
              </td>
              <?php foreach((array)$unidadNegocio['espacios'] as $key => $espacio): ?>
                <td>
                  <?php echo $espacio['valor']; ?>
                </td>
              <?php endforeach; ?>
              <td>
                <?php echo $unidadNegocio['resultadoUnidadNegocio']; ?>
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
        <tr>
          <td colspan="8"><strong>RANGO DE CALIFICACION DE 1 A 5</strong></td>
          <td> <?php echo $informacionReporte['calificacionFinal']; ?> </td>
        </tr>
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
  th, td {
    vertical-align: middle!important;
  }
</style>