<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use app\assets\IntranetAsset;
use app\modules\intranet\models\Menu;
use app\modules\intranet\models\Tareas;
use app\modules\intranet\models\MenuPortales;
use app\modules\intranet\models\AuthItem;
use app\modules\intranet\models\Opcion;
use app\modules\intranet\models\OpcionesUsuario;
use nirvana\showloading\ShowLoadingAsset;

ShowLoadingAsset::register($this);
IntranetAsset::register($this);

$srcPictureUser = "''";
$srcLogo = Yii::$app->homeUrl . 'img/logo_copservir.png';

$userName = "";

if (!Yii::$app->user->isGuest) {
    $srcPictureUser = Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->getImagenPerfil();
    $userName = Yii::$app->user->identity->alias;
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script> requestUrl = "<?= Yii::$app->getUrlManager()->getBaseUrl() ?>";</script>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="header navbar navbar-inverse ">
            <div class="navbar-inner"><!-- BEGIN TOP NAVIGATION BAR -->
                <div class="header-seperation">
                    <ul class="nav pull-left notifcation-center visible-xs visible-sm">
                        <li class="dropdown">
                            <a href="#main-menu" data-webarch="toggle-left-side">
                                <!-- <div class="iconset top-menu-toggle-white"></div> -->
                                <i class="fa fa-bars menu-movil" aria-hidden="true" style="color:#357296;"></i>

                            </a>
                        </li>
                    </ul>

                    <!-- BEGIN LOGO -->
                    <?= Html::a('<img src=' . $srcLogo . ' class="logo" data-src="" data-src-retina="" style="margin: 6px 30px; width: 180px; position:relative"/>', ['sitio/index'], []) ?>
                    <!-- END LOGO -->
                    <ul class="nav pull-right notifcation-center visible-xs visible-sm">
                        <!--icono menu derecha-->
                        <li class="dropdown">
                            <a href="#" class="chat-menu-toggle" data-webarch="toggle-right-side">
                                <!-- <div class="iconset top-menu-toggle-white"></div> -->
                                <i class="fa fa-ellipsis-v menu-movil" aria-hidden="true" style="color:#357296;"></i>
                            </a>
                        </li>
                    </ul>
                </div><!-- END RESPONSIVE MENU TOGGLER -->

                <div class="header-quick-nav" >
                    <div class="pull-left"><!-- BEGIN TOP NAVIGATION MENU -->
                        <ul class="nav quick-section">
                            <li class="quicklinks"> <a href="#" class="" id="layout-condensed-toggle" >
                                    <div class="iconset top-menu-toggle-dark"></div>
                                </a> </li>
                        </ul>
                        <ul class="nav quick-section">
                            <li class="quicklinks"> <span class="h-seperate"></span></li>
                            <li>
                              <?= $this->render('emisora', []); ?>
                            </li>

                            <!-- BUSCADOR -->
                            <!--
                            <li class="m-r-10 input-prepend inside search-form no-boarder">
                                <?php // Html::beginForm(['contenido/buscador-noticias'], 'post', ['id' => 'formBuscadorNoticias']); ?>
                                <span class="add-on pull-left">
                                    <span class="iconset top-search pull-left"></span>
                                </span>

                                <input id="busqueda" name="q" type="text"  class="no-boarder " placeholder="Escriba el texto a buscar"
                                style="width:250px;" size="40">
                                <?php // Html::endForm() ?>
                            </li>
                            -->
                        </ul>
                    </div><!-- END TOP NAVIGATION MENU -->

                    <div class="pull-right"><!-- BEGIN CHAT TOGGLER -->
                        <div id="notification-div" class="chat-toggler">
                            <a href="#" class="dropdown-toggle" id="my-notification-list" data-placement="bottom"  data-content='' data-toggle="dropdown" data-original-title="Notificaciones">
                                <div class="user-details">
                                    <div class="username">
                                        <span id="notification-count" class="badge badge-important"></span>
                                        <span class="bold"><?= $userName ?></span>
                                    </div>
                                </div>
                                <div class="iconset top-down-arrow"></div>
                            </a>
                            <div id="notification-list" style="display:none"></div>
                            <div class="profile-pic">
                                <img src=<?= "" . $srcPictureUser ?> alt="" data-src="" data-src-retina="" width="35" height="35" />
                            </div>
                            <div style="margin-left: 15px;display: inline-block; float: left; line-height: 35px;">
                              <?php $numTareas =  Tareas::getNumeroTareas(Yii::$app->user->identity->numeroDocumento)?>
                              <?= Html::a("<span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span><span class='badge badge-success' style='position: absolute;'> $numTareas</span>", ['tareas/listar-tareas']) ?>
                            </div>
                        </div>
                        <ul class="nav quick-section ">
                            <li class="quicklinks">
                                <a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">
                                    <div class="iconset top-settings-dark "></div>
                                </a>
                                <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                                    <li><?= Html::a('Mi cuenta', ['usuario/perfil']) ?></li>
                                    <!-- li><?= Html::a('Mi calendario', ['calendario/']) ?></li-->
									<li><?= Html::a('Mi menu', ['sitio/menu/']) ?></li>
                                    <li><?= Html::a('Mi pantalla de inicio', ['usuario/pantalla-inicio']) ?></li>
                                    <li class="divider"></li>
                                    <li>
                                        <?= Html::beginForm(['usuario/salir'], 'post', ['id' => 'form-salir']); ?>
                                        <?= Html::submitButton('<i class="fa fa-power-off"></i> Salir', ['class' => 'btn btn-link']); ?>
                                        <?= Html::endForm(); ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div> <!-- END CHAT TOGGLER -->


                </div><!-- END TOP NAVIGATION MENU -->
            </div><!-- END TOP NAVIGATION BAR -->
        </div>
        <!-- END HEADER -->

        <!-- BEGIN CONTAINER -->
        <div class="page-container row-fluid">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar " id="main-menu">
                <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
                    <!-- BEGIN MINI-PROFILE -->
                    <div class="user-info-wrapper">
                        <div class="profile-wrapper"> <img src=<?= "" . $srcPictureUser ?>  alt="" data-src="" data-src-retina="" width="69" height="69" /> </div>
                        <div class="user-info">
                            <div class="greeting">Bienvenido</div>
                            <div class="username"> <span class="semi-bold"><?= $userName ?></span></div>
                        </div>
                    </div>
                    <!-- END MINI-PROFILE -->

                    <!-- BEGIN SIDEBAR MENU -->
                    <div class="clearfix"></div>
                    <ul>
                        <li><?= Html::a('<i class="icon-custom-home"></i> <span class="title">Inicio</span> <span class="selected"></span>', ['/intranet/sitio/index']) ?></li>
			<li class=""> <a href="javascript:;"> <i class="fa fa-user-plus"></i> <span class="title">Menú Usuario</span> <span class="arrow "></span> </a>
                            <ul class="sub-menu">
                                <li>
                                    <?= Html::a('<i class="fa fa-list-alt"></i> <span class="title">Mis Publicaciones</span> <span class="selected"></span>', ['/intranet/contenido/mis-publicaciones']) ?>
                                </li>

                                <!-- li>
                                    <?= Html::a('<i class="fa fa-list-ul"></i> <span class="title">Mis Tareas</span> <span class="selected"></span>', ['/intranet/tareas/listar-tareas']) ?>
                                </li -->
                                <!-- li>
                                    <?= Html::a('<i class="fa fa-sitemap"></i> <span class="title">Organigrama</span> <span class="selected"></span>', ['intranet/sitio/organigrama']) ?>
                                </li-->
                                <!-- li>
                                    <?= Html::a('<i class="fa fa-calendar"></i> <span class="title">Calendario</span> <span class="selected"></span>', ['/intranet/calendario/']) ?>
                                </li-->
                                <!-- MENU CORPORATIVO -->
                                <li>
                                    <a href="http://intranet2.copservir.com/copservirportal/aplespecial/aplinternos/usrlogin_nueva_intranet.php?cedula=<?=Yii::$app->user->identity->numeroDocumento?>&seguir=168" target="_blank"><i class="fa fa-hourglass-start"></i> <span class="title">Mis Permisos</span> <span class="selected"></span></a>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-file-pdf-o"></i> <span class="title">Mis Certificados</span> <span class="selected"></span>', ['/intranet/sitio/contenido?modulo=83']) ?>
                                </li>
                                <li>
                                    <a href="https://bancolombia.olb.todo1.com/olb/Init" target="_blank"><i class="fa fa-money"></i> <span class="title">Bancolombia</span> <span class="selected"></span></a>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-cogs"></i> <span class="title">Aplicativos Internos</span> <span class="selected"></span>', ['/intranet/sitio/contenido?modulo=86']) ?>
                                </li>
                            </ul>
                        </li>

                        <!--
                        <li class="start open active">
                        <?= Html::a('<i class="icon-custom-home"></i> <span class="title">Inicio</span> <span class="selected"></span>', ['/intranet/sitio/index']) ?>
                        </li>
                        -->

                        <!--
                        <li >
                        <?= Html::a('<i class="fa fa-book"></i> <span class="title">Docs procedimientos</span> <span class="selected"></span>', ['/intranet/categoria-documento/']) ?>
                        </li>
                        -->

                        <!--OPCIONES SELECCIONADAS POR EL USUARIO DEL MENU CORPORATIVO -->
                        <li id='list-menu-corporativo'></li>
                        <?= $this->render('_menuCorporativoUsuario', ['menu' => Menu::getMenuPadre(), 'opciones' => new OpcionesUsuario(Yii::$app->user->identity->numeroDocumento)]); ?>

                        <!-- MENU PORTALES -->
                        <?php MenuPortales::generarMenu(Yii::$app->controller->module->id) ?>

                        <!-- MENU ADMIN -->
                        <?php if (!Yii::$app->user->isGuest): ?>
                            <?php $listPermisos =  AuthItem::consultarPermisos(Yii::$app->user->identity->numeroDocumento)?>
                            <?php if(!empty($listPermisos)): ?>
                                <li class=""> <a href="javascript:;"> <i class="glyphicon glyphicon-cog"></i> <span class="title">Administraci&oacute;n</span> <span class="arrow "></span> </a>
                                    <ul class="sub-menu">
                                    <?php foreach ($listPermisos as $objPermiso): ?>
                                        <li>
                                        <?= Html::a('<i class="glyphicon glyphicon-cog"></i> <span class="title">' . $objPermiso->title . '</span> <span class="selected"></span>', [$objPermiso->url], []) ?>
                                        </li>
                                    <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endif;?>
                        <?php endif; ?>
                    </ul>
                    <div class="clearfix"></div>
                    <!-- END SIDEBAR MENU -->
                </div>
            </div>

            <a href="#" class="scrollup">Scroll</a> <!-- END SIDEBAR -->

            <!-- BEGIN PAGE CONTAINER-->
            <div class="page-content"><!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div class="content ">
                    <div class="page-title"></div>
                    <div id="container" class="">
                        <?php if(isset($this->params['breadcrumbs']) && !empty($this->params['breadcrumbs'])): ?>
                            <?=
                            Breadcrumbs::widget([
                                'itemTemplate' => "<li>{link}</li>\n",
                                'homeLink' => [
                                    'label' => 'Inicio',
                                    'url' => ['/intranet/'],
                                ],
                                'links' => $this->params['breadcrumbs'],
                            ]);
                            ?>
                            <div class="space-1"></div>
                        <?php endif;?>
                    <?= $content ?>
                    </div><!-- END PAGE -->
                </div>
            </div>
            <!-- END PAGE CONTAINER -->


<!-- BEGIN CHAT -->
<div class="chat-window-wrapper">
    <div id="main-chat-wrapper" class="inner-content">
        <div class="chat-window-wrapper scroller scrollbar-dynamic" id="chat-users" >

            <div class="side-widget fadeIn">
               <div class="side-widget-title">Notificaciones</div>
                <div class="side-widget-content">
                 <div id="groups-list">
                    <ul class="groups" >
                        <li><a href="#"><i class="fa fa-caret-right fa-lg" aria-hidden="true"></i> Ver todo</a></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="side-widget fadeIn">
               <div class="side-widget-title">Tareas</div>
               <div id="favourites-list">
                <div class="side-widget-content" >
                    <ul class="groups" >
                        <li><a href="#"><i class="fa fa-caret-right fa-lg" aria-hidden="true"></i> Tareas pendientes</a></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="side-widget">
               <div class="side-widget-title">Detalles de mi cuenta</div>
                 <div class="side-widget-content" id="friends-list">
                    <ul class="groups" >
                      <li><?= Html::a('<i class="fa fa-caret-right fa-lg" aria-hidden="true"></i> Mi cuenta', ['usuario/perfil']) ?></li>
                      <li><?= Html::a('<i class="fa fa-caret-right fa-lg" aria-hidden="true"></i> Mi menu', ['sitio/menu/']) ?></li>
                      <li><?= Html::a('<i class="fa fa-caret-right fa-lg" aria-hidden="true"></i> Mi pantalla de inicio',
                       ['usuario/pantalla-inicio']) ?></li>
                      <li>
                          <?= Html::beginForm(['usuario/salir'], 'post', ['id' => 'form-salir']); ?>
                          <?= Html::submitButton('<i class="fa fa-power-off"></i> Salir', ['class' => 'btn btn-primary btn-lg btn-block']); ?>
                          <?= Html::endForm(); ?>
                      </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CHAT -->


        </div>
        <!-- END CONTAINER -->
        <div class="div-modal-denuncio-contenido"></div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
