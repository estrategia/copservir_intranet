<?php
  use yii\helpers\Html;
  $this->title = 'Consulta de productos';
  $this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panel-title">
          <h3>Consulta de productos</h3>
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <form action="<?= (Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/visitamedica/productos/buscar') ?>" method="GET" id="busqueda">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                 <input type="text" name="term" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <input type="submit" class="btn btn-default" value="Buscar">
              </div>
            </div>
          </form>
        </div>
        <br>
        <div class="row">
          <?php if (isset($productos)): ?>
            <div class="table-responsive">
              <table class="table table-bordered datatable">
                <thead>
                  <tr class="tableizer-firstrow">
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Presentacion</th>
                    <th>Categoria</th>
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
                        <?php echo $producto['descripcionProducto'] ?>
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
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>