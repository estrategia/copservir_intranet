<?php
  use yii\helpers\Html;
  $this->title = 'Consulta de productos';
  $this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <div align="center">
            <h3>
              <strong>SECTOR:</strong>
              <?php if (\Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad'])): ?>
              <?= \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad']); ?>
              - 
              <?= \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreSector']); ?>
              <?php endif ?>
              </div>
            </h3>
          <form action="<?= (Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/visitamedica/productos/buscar') ?>" method="GET" id="busqueda">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                 <input type="text" name="term" class="form-control">
                 <?= Yii::$app->session->getFlash('error') ?>
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="Buscar">
              </div>
            </div>
          </form>
        </div>
        <br>
        <div class="row">
          <?php if (isset($productos)): ?>
              <table class="table table-bordered" id="busqueda-results">
                <thead>
                  <tr class="tableizer-firstrow">
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Presentacion</th>
                    <th>Mapa</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($productos as $producto): ?>
                    <tr>
                      <td>
                        <?php echo $producto['codigoProducto'] ?>
                      </td>
                      <td>
                        <?php echo $producto['descripcionProducto'] ?>
                      </td>       
                      <td>
                        <?php echo $producto['presentacionProducto'] ?>
                      </td>       
                      <td>
                        <a href=" <?php echo (Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/visitamedica/productos/producto/' . $producto['codigoProducto']); ?> ">
                          <i class="glyphicon glyphicon-map-marker"></i>
                        </a>
                      </td>      
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>