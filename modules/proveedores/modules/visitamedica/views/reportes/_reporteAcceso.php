<?php 
  $baseUrl = Yii::$app->getUrlManager()->getBaseUrl(); 
  $this->title = 'Consultas de productos';
  $this->params['breadcrumbs'][] = ['label' => 'Reportes', 'url' => ['/proveedores/visitamedica/reportes']];
  $this->params['breadcrumbs'][] = ['label' => 'Acceso de usuarios'];
?>

<div class="row">
  <div class="col-md-12">
    <a  class="btn btn-default" href=" <?= $baseUrl . '/proveedores/visitamedica/reportes/acceso/hoy' ?> ">Acceos hoy</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/proveedores/visitamedica/reportes/acceso/ayer' ?> ">Accesos ayer</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/proveedores/visitamedica/reportes/acceso/semana' ?> ">Accesos esta semana</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/proveedores/visitamedica/reportes/acceso/semana-anterior' ?> ">Accesos semana pasada</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/proveedores/visitamedica/reportes/acceso/mes' ?> ">Accesos este mes</a>
    <a  class="btn btn-default" href=" <?= $baseUrl . '/proveedores/visitamedica/reportes/acceso/mes-anterior' ?> ">Accesos mes pasado</a>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
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
        <table class="table">
          <thead>
            <tr>
              <th>Numero de Documento</th> 
              <th>Ip</th> 
              <th>Fecha de conexion</th> 
            </tr>
          </thead>
          <tbody>
            <?php foreach ($registros as $registro): ?>
              <tr>
                <td><?php echo $registro['numeroDocumento']; ?> </td>
                <td><?php echo $registro['ip']; ?> </td>
                <td><?php echo $registro['fechaConexion']; ?> </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
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
        data: datosGrafica,
        resize: true

      });
    } else {
      var ykeys = Object.keys(datosGrafica[0]).slice(0, -1);

      var grafica = new Morris.Line({
          element: 'graficaAcceso',
          data: datosGrafica ,
          xkey: 'fechaConexion',
          ykeys: ykeys,
          labels: ykeys,
          resize: true,
          // behaveLikeLine: true

        });
      // grafica.setData = datos; 
    }
  };
</script>