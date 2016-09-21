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
                                <div class="iconset top-menu-toggle-white"></div>
                            </a>
                        </li>
                    </ul>

                    <!-- BEGIN LOGO -->
                    <?= Html::a('<img src=' . $srcLogo . ' class="logo" data-src="" data-src-retina="" style="margin: 6px 30px; width: 180px; position:relative"/>', ['sitio/index'], []) ?>
                    <!-- END LOGO -->
                    <ul class="nav pull-right notifcation-center"></ul>
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
                            <!--
                            <li class="m-r-10 input-prepend inside search-form no-boarder">
                                <?= Html::beginForm(['contenido/buscador-noticias'], 'post', ['id' => 'formBuscadorNoticias']); ?>
                                <span class="add-on">
                                    <span class="iconset top-search"></span>
                                </span>
                                <input id="busqueda" name="busqueda" type="text"  class="no-boarder " placeholder="Buscar..." style="width:250px;">
                                <?= Html::endForm() ?>
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
        </div>
        <!-- END CONTAINER -->
        <div class="div-modal-denuncio-contenido"></div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
