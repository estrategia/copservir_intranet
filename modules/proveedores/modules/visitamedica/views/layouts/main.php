<?php

use nirvana\showloading\ShowLoadingAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\assets\VisitaMedicaAsset;
use app\modules\intranet\models\AuthItem;


ShowLoadingAsset::register($this);
VisitaMedicaAsset::register($this);
?>
<!-- <?php var_dump( Yii::$app->authManager->getRolesByUser(90909)); ?> -->
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
    <?php if (!Yii::$app->user->isGuest): ?>
    <?php $baseUrl = Yii::$app->getUrlManager()->getBaseUrl(); ?>
      <div class="page-container">
         <div class="page-sidebar">
            <!-- START X-NAVIGATION -->
            <ul class="x-navigation"> 
                <li class="xn-logo">
                <a href=" <?= $baseUrl . '/proveedores/visitamedica/ubicacion' ?> " class="cambio-ubicacion-small">
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
                    <!-- <a href="index.php" class="visible-sm visible-md visible-xs"><img src=" <?php echo Yii::$app->homeUrl . 'img/multiportal/proveedores/logo-proveedores.png' ?> "></a> -->
                    <a href="#" class="x-navigation-control" style="color: black"></a>
                </li>
                <li class="xn-profile">
                    <a href="#" class="profile-mini">
                    </a>
                    <div class="profile">
                        <div class="profile-image hidden-xs hidden-sm">
                          <img src=" <?php echo Yii::$app->homeUrl . 'img/multiportal/proveedores/logo-vimed.png' ?> " alt="">
                        </div>
                        <div class="profile-data">
                            <div class="profile-data-name">
                            <?php if(Yii::$app->user->identity->objUsuarioProveedor):?>
                              <?= Yii::$app->user->identity->objUsuarioProveedor->nombre; ?> 
                              <?= Yii::$app->user->identity->objUsuarioProveedor->primerApellido; ?>
                              <?php endif;?>
                            </div>
                            <div class="profile-data-title"></div>
                        </div>
                    </div>                                                                        
                </li>

                <?php $listPermisos =  AuthItem::consultarPermisos(Yii::$app->user->identity->numeroDocumento, Yii::$app->controller->module->id)?>
                    <?php if(!empty($listPermisos)): ?>
                      <?php foreach ($listPermisos as $objPermiso): ?>
                          <li>
                          <?= Html::a('<i class="glyphicon glyphicon-arrow-right"></i> <span class="title">' . $objPermiso->title . '</span> <span class="selected"></span>', [$objPermiso->url], []) ?>
                          </li>
                      <?php endforeach; ?>
                    <?php endif; ?>
                
                <!-- <?php if(\Yii::$app->user->identity->tienePermiso('visitaMedica_productos_buscar')):?>
	                <li>
	                    <a href="<?= ($baseUrl . '/proveedores/visitamedica/productos/buscar')?>"><span class="fa fa-search"></span> <span class="xn-text">Consulta Productos</span></a>                        
	                </li> 
                <?php endif;?>
                
                <?php if(\Yii::$app->user->identity->tienePermiso('visitaMedica_usuario_correo-admin')):?>
	                <li>
	                    <a href=" <?= ($baseUrl . '/proveedores/visitamedica/usuario/correo-admin') ?> "><span class="fa fa-phone"></span> <span class="xn-text">Contacto</span></a>                        
	                </li> 
                <?php endif;?>
                
                <?php if(\Yii::$app->user->identity->tienePermiso('proveedores_usuario')):?>
	                <li>
	                    <a href="<?= ($baseUrl . '/proveedores/visitamedica/usuario/mi-cuenta')?>"><span class="fa fa-user"></span> <span class="xn-text">Mi Cuenta</span></a>                        
	                </li> 
                <?php endif;?>
                
                <?php if(\Yii::$app->user->identity->tienePermiso('visitaMedica_reportes_index')):?>
	                <li>
	                    <a href="<?= ($baseUrl . '/proveedores/visitamedica/reportes')?>"><span class="fa fa-tags"></span> <span class="xn-text">Registro de Uso</span></a>                        
	                </li>  
                <?php endif;?> -->
                <li data-toggle="tooltip" data-placement="bottom" title="Salir">
                  <?= Html::a('<span class="glyphicon glyphicon-off"></span><span class="title">Salir</span>', ['/proveedores/usuario/salir'], ['data'=>[
                      'method' => 'post',
                      'params'=>['id'=>'form-salir'],
                            ],
                    'class'=>'salir',
                    ])
                  ?>
              </li>
                 
                <!--  
                <li>
                    <a href="logout.php?doLogout=true" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> <span class="xn-text">Salir</span></a>                        
                </li>
                -->
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
              
              <!-- <li class="xn-icon-button pull-right" data-toggle="tooltip" data-placement="bottom" title="Ayuda">
                  <?= Html::a('<span class="glyphicon glyphicon-question-sign"></span>', ['/proveedores/visitamedica/usuario/ayuda']) 
                  ?>
              </li> -->
               
            </ul>

            <div class="page-content-wrap">
                  <div id="container">
                    <?php if(isset($this->params['breadcrumbs']) && !empty($this->params['breadcrumbs'])): ?>
                      <?=
                      Breadcrumbs::widget([
                          'itemTemplate' => "<li>{link}</li>\n",
                          'homeLink' => [
                              'label' => 'Visita medica',
                              'url' => ['/proveedores/visitamedica/'],
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
     <?php endif; ?> 
    <?php $this->endBody() ?>
  </body>
</html>

<?php $this->endPage() ?>
