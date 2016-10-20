<?php

use app\assets\VisitaMedicaAsset;
use nirvana\showloading\ShowLoadingAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


ShowLoadingAsset::register($this);
VisitaMedicaAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="<?= Yii::$app->charset ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <?= Html::csrfMetaTags() ?>
      <?php $this->head() ?>
      <script> requestUrl = "<?= Yii::$app->getUrlManager()->getBaseUrl() ?>";</script>
      <script> gmapKey = "<?= Yii::$app->params['google']['llaveMapa'] ?>";</script>

  </head>
  <body>
    <?php $this->beginBody() ?>
    <?php $baseUrl = Yii::$app->getUrlManager()->getBaseUrl(); ?>
      <div class="page-container">



         <div class="page-sidebar">
            <!-- START X-NAVIGATION -->

            <ul class="x-navigation"> 
                <li class="xn-logo">
                    <!-- <a href="index.php"><img src="imagenes/copservir.png" height="40"></a> -->
                    <a href="#" class="x-navigation-control"></a>
                </li>
                <li class="xn-profile">
                    <a href="#" class="profile-mini">
                    </a>
                    <div class="profile">
                        <div class="profile-image">
                        
                        </div>
                        <div class="profile-data">
                            <div class="profile-data-name"> 
                              <?= Yii::$app->user->identity->objUsuarioProveedor->nombre; ?> 
                              <?= Yii::$app->user->identity->objUsuarioProveedor->primerApellido; ?> 
                            </div>
                            <div class="profile-data-title"></div>
                        </div>
                        <div class="profile-controls">
                            <a href="index.php?opcion=usuario" class="profile-control-left"><span class="fa fa-info"></span></a>
                            <a href="index.php?opcion=mensajes" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                        </div>
                    </div>                                                                        
                </li>
                <li class="xn-title">Navegación</li>
               <!--  <li class="active">
                    <a href="index.php"><span class="fa fa-desktop"></span> <span class="xn-text">Panel de Control</span></a>                        
                </li>         -->            
                <li>
                    <a href="<?= ($baseUrl . '/proveedores/visitamedica/productos/buscar')?>"><span class="fa fa-search"></span> <span class="xn-text">Consulta Productos</span></a>                        
                </li> 
                <li>
                    <a href=" <?= ($baseUrl . '/proveedores/visitamedica/usuario/correo-admin') ?> "><span class="fa fa-phone"></span> <span class="xn-text">Contacto</span></a>                        
                </li>     
                <li>
                    <a href="<?= ($baseUrl . '/proveedores/visitamedica/usuario/mi-cuenta')?>"><span class="fa fa-user"></span> <span class="xn-text">Mi Cuenta</span></a>                        
                </li> 
                <li>
                    <a href="<?= ($baseUrl . '/proveedores/visitamedica/reportes')?>"><span class="fa fa-tags"></span> <span class="xn-text">Registro de Uso</span></a>                        
                </li>  
                <li>
                    <a href="<?= ($baseUrl . '/proveedores/visitamedica/usuario/admin')?>"><span class="fa fa-users"></span> <span class="xn-text">Usuarios</span></a> 
                </li> 
                <li>
                    <a href="logout.php?doLogout=true" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> <span class="xn-text">Salir</span></a>                        
                </li>                    

            </ul>
            <!-- END X-NAVIGATION -->

          </div>
          
          <div class="page-content">
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
              <!-- TOGGLE NAVIGATION -->
              <li class="xn-icon-button">
                  <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
              </li>
              <li class="xn">
                <a href=" <?= $baseUrl . '/proveedores/visitamedica/ubicacion' ?> " class="cambio-ubicacion">
                    <span class="fa fa-map-marker"></span>
                    <?php if (\Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad'])): ?>
                      
                      <?= \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad']); ?>
                      -
                      <?= \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreSector']); ?>
                      (Cambiar ubicacion)
                    <?php else: ?>
                      (Seleccionar ubicacion)
                    <?php endif ?>
                </a>
              </li>
              <li class="xn-icon-button pull-right">
                  <a href="logout.php?doLogout=true" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
              </li>
            </ul>

            <div class="page-content-wrap">

                  <div id="container">
                    <?php if(isset($this->params['breadcrumbs']) && !empty($this->params['breadcrumbs'])): ?>
                      <?=
                      Breadcrumbs::widget([
                          'itemTemplate' => "<li>{link}</li>\n",
                          'homeLink' => [
                              'label' => 'Inicio',
                              'url' => ['/proveedores/'],
                          ],
                          'links' => $this->params['breadcrumbs'],
                      ]);
                      ?>
                      <div class="space-1"></div>
                    <?php endif;?>
                    <div class="space-1"></div>
                    <?= $content ?>
                  </div>
            </div>

          </div>

        </div>
        
    <?php $this->endBody() ?>
  </body>
</html>

<?php $this->endPage() ?>
