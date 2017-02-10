<?php 
  $baseUrl = Yii::$app->getUrlManager()->getBaseUrl(); 
  $this->title = 'Consultas de productos';
  $this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['/intranet/visitamedica/reportes']];
  $this->params['breadcrumbs'][] = ['label' => 'Reporte de productos'];
?>

<div class="row">
  <div class="col-md-12">
    <a  class="btn btn-default" href=" <?= $baseUrl . '/intranet/visitamedica/reportes/producto/hoy' ?> ">Busquedas hoy</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/intranet/visitamedica/reportes/producto/ayer' ?> ">Busquedas ayer</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/intranet/visitamedica/reportes/producto/semana' ?> ">Busquedas esta semana</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/intranet/visitamedica/reportes/producto/semana-anterior' ?> ">Busquedas semana pasada</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/intranet/visitamedica/reportes/producto/mes' ?> ">Busquedas este mes</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/intranet/visitamedica/reportes/producto/mes-anterior' ?> ">Busquedas mes pasado</a>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="panel">
      <div class="panel-header"></div>
      <div class="panel-body">
        <div id="graficaAcceso" style="height: 45vh;"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="panel-header"></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Presentacion</th>
                <th>Codigo Ciudad</th>
                <th>Ciudad</th>
                <th>Codigo Sector</th>
                <th>Sector</th>
                <th>Ip</th> 
                <th>Fecha de conexion</th> 
              </tr>
            </thead>
            <tbody>
              <?php foreach ($registros as $registro): ?>
                <tr>
                  <td><?php echo $registro['codigoProducto']; ?> </td>
                  <td><?php echo $registro['descripcionProducto']; ?> </td>
                  <td><?php echo $registro['presentacionProducto']; ?> </td>
                  <td><?php echo $registro['codigoCiudad']; ?> </td>
                  <td><?php echo $registro['nombreCiudad']; ?> </td>
                  <td><?php echo $registro['codigoSector']; ?> </td>
                  <td><?php echo $registro['nombreSector']; ?> </td>
                  <td><?php echo $registro['ip']; ?> </td>
                  <td><?php echo $registro['fechaConsulta']; ?> </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  window.onload = function() {
    var datosGrafica = <?php echo json_encode($datosGrafica); ?>;
    var tiempo = "<?php echo $tiempo; ?>";
    if (tiempo == 'hoy' || tiempo == 'ayer') {
      Morris.Donut({
        element: 'graficaAcceso',
        data: datosGrafica[0],
        resize: true
      });
    } else {
      var puntos = datosGrafica[1];
      var ykeys = Object.keys(puntos[0]).slice(0, -1);
      var grafica = new Morris.Line({
          element: 'graficaAcceso',
          data: puntos,
          xkey: 'fechaConsulta',
          ykeys: ykeys,
          labels: ykeys,
          resize: true
        });
      // grafica.setData = datos; 
    }
  };
</script>