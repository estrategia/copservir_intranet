<?php  
  $this->registerJsFile('https://maps.googleapis.com/maps/api/js?client=' . Yii::$app->params['google']['llaveMapa']);
  $this->registerJsFile( Yii::$app->getUrlManager()->getBaseUrl() . '/js/visitamedica/mapa-sector.js');
  // $this->registerJsFile("https://maps.googleapis.com/maps/api/js?v=3.11&sensor=false");

  $this->title = $producto['descripcionProducto'];
  $this->params['breadcrumbs'][] = ['label' => 'Busqueda de productos', 'url' => ['productos/buscar']];
  $this->params['breadcrumbs'][] = $this->title;
?>
<?php if($result == 0): ?>
<div class="alert alert-warning alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
  El producto seleccionado, no se encontro en el sector 
  <?php if (\Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad'])): ?> 
    <?= \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad']); ?>
    -
    <?= \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreSector']); ?>
  <?php endif ?>, por favor comuniquese con la persona encargada de su laboratorio que atiende la cuenta de Copservir Ltda. para la revisión de inventarios y maximos y minimos.
</div>
<?php elseif ($result == 1): ?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">
          Ubicacion del Producto: <?php echo $producto['descripcionProducto'] ?>
        </h3>
      </div>
      <div class="panel-body panel-body-map">
        <div class="row">
          <div class="col-md-7 col-xs-12 col-sm-12">
            <div id="map" class="mapa-producto" style= "width: 100%;"></div>
          </div>
          <div class="col-md-5 col-xs-12">
            <?php foreach ($infoSector as $pdv): ?>
              <div class="row">
                <div class="col-md-6 col-xs-6">
                  <addres>
                    <strong> <?php echo $pdv['nombrePDV'] ?> </strong> <br>
                    <?php echo $pdv['direccionPDV'] ?> <br>
                    <?php echo $pdv['nombreCiudad'] ?> <br>
                    <?php echo $pdv['nombreBarrio'] ?> <br>
                    Teléfono: <?php echo $pdv['telefono'] ?> <br>
                  </addres>
                </div>
                <div class="col-md-6 col-xs-6">
                  <span href="#" class="tile tile-default">
                    <span>
                    <?php echo $pdv['producto']['saldo'] ?> Und
                    </span>
                    <p> Max: <?php echo $pdv['producto']['maximo'] ?> / Min: <?php echo $pdv['producto']['minimo'] ?> </p>
                    <p> Rotación: <?php echo $pdv['producto']['rotacion'] ?> / Clase: <?php echo $pdv['producto']['clase']; ?> </p>
                  </span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"></h3>
      </div>

      <div class="panel-body panel-body-map">
        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12 galeria-producto">
            <?php if (sizeof($producto['imagenesProducto']) == 0): ?>
              <div class="col-md-6 col-md-offset-4">
                <img class="img-responsive" src=" <?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/img/multiportal/proveedores/no-image.png' ?> " alt="">
              </div>
            <?php else: ?>
              <?php if (sizeof($producto['imagenesProducto']) == 1): ?>
                <img src=" <?php echo $producto['imagenesProducto'][0]['rutaImagen'] ?> " alt=" <?php echo $producto['imagenesProducto'][0]['rutaImagen'] ?> " class="img-responsive" title="<?php echo $producto['imagenesProducto'][0]['tituloImagen'] ?>">
              <?php else: ?>
                <div id="gallery" class="ad-gallery">
                  <div class="ad-image-wrapper">
                  </div>
                  <div class="ad-controls">
                  </div>
                  <div class="ad-nav">
                    <div class="ad-thumbs">
                      <ul class="ad-thumb-list">
                        <?php foreach ($producto['imagenesProducto'] as $imagen): ?>
                          <li>
                            <a href=" <?php echo $imagen['rutaImagen'] ?> ">
                              <img class="ad-thumb width-thumb-owl product-prom"src="<?php echo $imagen['rutaImagen'] ?>" alt="<?php echo $imagen['nombreImagen'] ?>" title="<?php echo $imagen['tituloImagen'] ?>">
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              <?php endif ?>
            <?php endif ?>
          </div>

          <div class="vr col-md-1 hidden-sm hidden-xs"></div>
          <div class="col-md-4 info-producto">
            
            <br><br><br>

            <div class="row header-producto">
              <!-- <span class="descuento"> 50% dcto </span> -->
              <h3 class="nombre-producto"> <?php echo $producto['descripcionProducto'] ?> </h3>
              <h4 class="presentacion-producto"> <?php echo $producto['presentacionProducto'] ?> </h4>
              <h4 class="codigo-producto"> Código: <?php echo $producto['codigoProducto'] ?> </h4>
            </div>
            
            <br>

            <div class="row info-precios">
              <?php if( sizeof($producto['fraccion'])) : ?>

                <div class="col-md-6 col-sm-6 info-unitario">
                  <br class="hidden-sm hidden-xs">
                  <br>
                  <br>
                  <br>
                  <h5 class="presentacion-unitario"> <?php echo Yii::$app->formatter->asDecimal($producto['presentacionProducto'], 3); ?> </h5>
                  <hr>
                  <h4 class="precio-base"> $ <?php echo Yii::$app->formatter->asDecimal($producto['precioUnidad']['precioBase'],3); ?> </h4>
                  <hr>
                  <h5 class="ahorro"> Ahorro: $ <?php echo Yii::$app->formatter->asDecimal($producto['precioUnidad']['ahorro'],3); ?> </h5>
                  <hr>
                  <h4 class="precio-real"> $ <?php echo Yii::$app->formatter->asDecimal($producto['precioUnidad']['precioReal'],3); ?> </h4>
                  <hr>
                </div>
                <div class="col-md-6 col-sm-6 info-fraccionado">
                  <br>
                  <p style="font-size: 1.1rem;">Unidad minima de venta (U.M.V)</p>
                  <hr>
                  <h5 class="presentacion-fraccionado"> 
                    <?php echo $producto['fraccion']['descripcionMedidaFraccion']; ?> x
                    <?php echo $producto['fraccion']['unidadFraccionamiento']; ?> 
                  </h5>
                  <hr>
                  <h4 class="precio-base"> $ <?php echo Yii::$app->formatter->asDecimal($producto['precioFraccion']['precioBase'],3); ?> </h4>
                  <hr>
                  <h5 class="ahorro"> Ahorro: $ <?php echo Yii::$app->formatter->asDecimal($producto['precioFraccion']['ahorro'],3); ?> </h5>
                  <hr>
                  <h4 class="precio-real"> $ <?php echo Yii::$app->formatter->asDecimal($producto['precioFraccion']['precioReal'],3); ?> </h4>
                  <hr>
                </div>
              <?php else : ?>
                <div class="col-md-12">
                  <table>
                    <tbody>
                      <tr>
                        <td valign="middle">
                          <p class="antes"> Antes: <span class="tachado"> $ <?php echo Yii::$app->formatter->asDecimal($producto['precioUnidad']['precioBase'], 3); ?></span></p>
                          <p class="ahorro"> Ahorro: $ <?php echo Yii::$app->formatter->asDecimal($producto['precioUnidad']['ahorro'], 3); ?> </p>
                        </td>
                        <td>
                          <h4 class="ahora"> $ <?php echo $producto['precioUnidad']['precioReal']; ?> </h4>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <hr>
                </div>
              <?php endif; ?>
              <p class="precio base" align="justify">Nota: El precio indicado a continuación hace referencia a los precios de <a href="larebajavirtual.com" style="color: red">www.larebajavirtual.com</a>, y puede variar con relación al del sector con el que se este haciendo la busqueda.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php $marks = json_encode($infoSector); ?>
<script>
  window.onload = function (){
    var pdvs = <?php echo $marks; ?> ;
    pdvs.forEach(function (pdv) {
      addMark(pdv.cordenadas.lat, pdv.cordenadas.lon, pdv.nombrePDV);
    });
  };
</script>