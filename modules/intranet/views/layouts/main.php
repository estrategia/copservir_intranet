<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\intranet\models\Menu;
use app\modules\intranet\models\Opcion;
use app\modules\intranet\models\OpcionesUsuario;

AppAsset::register($this);

$srcPictureUser = "''";
$userName = "";

if (!Yii::$app->user->isGuest) {
    $srcPictureUser = Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->imagenPerfil;
    $userName = Yii::$app->user->identity->alias;
    //$userDocumento = Yii::$app->user->identity->numeroDocumento;
}

$srcLogo = Yii::$app->homeUrl . 'img/logo_copservir.png';

$menu = Menu::find()->with('listSubMenu')->where('idPadre is NULL')->all();
$opciones = new OpcionesUsuario();
$opciones->opcionesUsuario(Yii::$app->user->identity->numeroDocumento);
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

        <!-- BEGIN PLANTILLA -->
        <div class="header navbar navbar-inverse ">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="navbar-inner">
                <div class="header-seperation">
                    <ul class="nav pull-left notifcation-center visible-xs visible-sm">
                        <li class="dropdown">
                            <a href="#main-menu" data-webarch="toggle-left-side">
                                <div class="iconset top-menu-toggle-white"></div>
                            </a>
                        </li>
                    </ul>
                    <!-- BEGIN LOGO -->
                    <a href="index.html">

                        <img src=<?= "" . $srcLogo ?> class="logo" alt=""  data-src="" data-src-retina="" style="margin: 6px 30px;
                             width: 180px; position:relative"/>

      </a>
      <!-- END LOGO -->
      <ul class="nav pull-right notifcation-center">
        <!--<li class="dropdown hidden-xs hidden-sm">
        	<a href="index.html" class="dropdown-toggle active" data-toggle="">
        		<div class="iconset top-home"></div>
        	</a>
        </li>
        <li class="dropdown hidden-xs hidden-sm">
        	<a href="email.html" class="dropdown-toggle" >
        		<div class="iconset top-messages"></div><span class="badge">2</span>
        	</a>
        </li>
		<li class="dropdown visible-xs visible-sm">
			<a href="#" data-webarch="toggle-right-side">
				<div class="iconset top-chat-white "></div>
			</a>
		</li>-->
      </ul>
      </div>
      <!-- END RESPONSIVE MENU TOGGLER -->
      <div class="header-quick-nav" >
      <!-- BEGIN TOP NAVIGATION MENU -->
	  <div class="pull-left">
        <ul class="nav quick-section">
          <li class="quicklinks"> <a href="#" class="" id="layout-condensed-toggle" >
            <div class="iconset top-menu-toggle-dark"></div>
            </a> </li>
        </ul>
        <ul class="nav quick-section">
          <!--<li class="quicklinks"> <a href="#" class="" >
            <div class="iconset top-reload"></div>
            </a> </li>-->
          <li class="quicklinks"> <span class="h-seperate"></span></li>
          <!--<li class="quicklinks"> <a href="#" class="" >
            <div class="iconset top-tiles"></div>
            </a> </li>-->
			<li class="m-r-10 input-prepend inside search-form no-boarder">

        <?= Html::beginForm(['contenido/buscador-noticias'], 'post', ['id'=> 'formBuscadorNoticias']); ?>
          <span class="add-on">
              <span class="iconset top-search"></span>
          </span>
          <input id="busqueda" name="busqueda" type="text"  class="no-boarder " placeholder="Buscar..." style="width:250px;">
        <?= Html::endForm()     ?>


                            </li>
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                    <!-- BEGIN CHAT TOGGLER -->
                    <div class="pull-right">
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
                            <div id="notification-list" style="display:none">

                            </div>
                            <div class="profile-pic">
                                <img src=<?= "" . $srcPictureUser ?> alt="" data-src="" data-src-retina="" width="35" height="35" />
                            </div>
                        </div>
                        <ul class="nav quick-section ">
                            <li class="quicklinks">
                                <a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">
                                    <div class="iconset top-settings-dark "></div>
                                </a>
                                <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                                    <li>
                                        <?= Html::a('Mi cuenta', ['usuario/perfil']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Mi calendario', ['calendario/']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Mi pantalla de inicio', ['usuario/pantalla-inicio']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Mis publicaciones &nbsp;&nbsp;
                  		<span class="badge badge-important animated bounceIn">2</span>', ['sitio/publicaciones']) ?>

                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <?= Html::beginForm(['usuario/salir'], 'post', ['id'=>'form-salir']); ?>
                                        <?=  Html::submitButton('<i class="fa fa-power-off"></i> Salir', ['class' => 'btn btn-link']);?>
                                        <?=  Html::endForm(); ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="quicklinks"> <span class="h-seperate"></span></li>
                            <li class="quicklinks">
                                <a href="#" class="chat-menu-toggle" data-webarch="toggle-right-side"><div class="iconset top-chat-dark "><span class="badge badge-important hide">1</span></div>
                                </a>
                                <div class="simple-chat-popup chat-menu-toggle hide" >
                                    <div class="simple-chat-popup-arrow"></div><div class="simple-chat-popup-inner">
                                        <div style="width:100px">
                                            <div class="semi-bold">David Nester</div>
                                            <div class="message">Hey you there </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- END CHAT TOGGLER -->
                </div>
                <!-- END TOP NAVIGATION MENU -->

            </div>
            <!-- END TOP NAVIGATION BAR -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container row">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar " id="main-menu">
                <!-- BEGIN MINI-PROFILE -->
                <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
                    <div class="user-info-wrapper">
                        <div class="profile-wrapper"> <img src=<?= "" . $srcPictureUser ?>  alt="" data-src="" data-src-retina="" width="69" height="69" /> </div>
                        <div class="user-info">
                            <div class="greeting">Bienvenido</div>
                            <div class="username"> <span class="semi-bold"><?= $userName ?></span></div>
                            <div class="status">Estado<a href="#">
                                    <div class="status-icon green"></div>
                                    Online</a></div>
                        </div>
                    </div>
                    <!-- END MINI-PROFILE -->
                    <!-- BEGIN SIDEBAR MENU -->
                    <p class="menu-title">MENU</p>
                    <ul>
                        <li class="start  open active ">
                            <?= Html::a('<i class="icon-custom-home"></i> <span class="title">Panel de control</span> <span class="selected"></span>', ['sitio/index'], []) ?>
                        </li>
                        <li >

                            <?= Html::a('<i class="fa fa-list-alt"></i> <span class="title">Mis Publicaciones</span> <span class="selected"></span>', ['contenido/mis-publicaciones'], []) ?>
                        </li>
                        <li >
                            <?= Html::a('<i class="fa fa-list-ul"></i> <span class="title">Tareas</span> <span class="selected"></span>', ['tareas/listar-tareas'], []) ?>
                        </li>
                        <li >
                            <?= Html::a('<i class="fa fa-sitemap"></i> <span class="title">Organigrama</span> <span class="selected"></span>', ['sitio/organigrama'], []) ?>
                        </li>
                        <li >
                            <?= Html::a('<i class="fa fa-calendar"></i> <span class="title">Calendario</span> <span class="selected"></span>', ['calendario/'], []) ?>
                        </li>

                        <?php foreach ($menu as $subMenu): ?>
                            <?php Menu::menuHtml($subMenu, $opciones->getOpcionesUsuario()); ?>
                        <?php endforeach; ?>

                        <li >
                            <?= Html::a('<i class="fa fa-sitemap"></i> <span class="title">Menú corporativo</span> <span class="selected"></span>', ['sitio/menu'], []) ?>
                        </li>

                    </ul>

                    <!-- END SIDEBAR MENU -->
                </div>
            </div>
            <a href="#" class="scrollup">Scroll</a>
            <div class="footer-widget">
                <div class="progress transparent progress-small no-radius no-margin">
                    <div class="progress-bar progress-bar-success animate-progress-bar" data-percentage="79%" style="width: 79%;"></div>
                </div>
                <div class="pull-right">
                    <div class="details-status"> <span class="animate-number" data-value="86" data-animation-duration="560">86</span>% </div>
                    <a href="lockscreen.html"><i class="fa fa-power-off"></i></a></div>
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN PAGE CONTAINER-->
            <div class="page-content">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div id="portlet-config" class="modal hide">
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button"></button>
                        <h3>Widget Settings</h3>
                    </div>
                    <div class="modal-body"> Widget settings form goes here </div>
                </div>
                <div class="clearfix"></div>
                <div class="content ">
                    <div class="page-title">

                    </div>
                    <div id="container">
                        <?= $content ?>

                    </div>
                    <!-- END PAGE -->
                </div>
            </div>
            <!-- BEGIN CHAT -->
            <div class="chat-window-wrapper">
                <div id="main-chat-wrapper" class="inner-content">
                    <div class="chat-window-wrapper scroller scrollbar-dynamic" id="chat-users" >
                        <div class="chat-header">
                            <div class="pull-left">
                                <input type="text" placeholder="search">
                            </div>
                            <div class="pull-right">
                                <a href="#" class="" ><div class="iconset top-settings-dark "></div> </a>
                            </div>
                        </div>
                        <div class="side-widget">
                            <div class="side-widget-title">group chats</div>
                            <div class="side-widget-content">
                                <div id="groups-list">
                                    <ul class="groups" >
                                        <li><a href="#"><div class="status-icon green"></div>Office work</a></li>
                                        <li><a href="#"><div class="status-icon green"></div>Personal vibes</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="side-widget fadeIn">
                            <div class="side-widget-title">favourites</div>
                            <div id="favourites-list">
                                <div class="side-widget-content" >
                                    <div class="user-details-wrapper active" data-chat-status="online" data-chat-user-pic="" data-chat-user-pic-retina="" data-user-name="Jane Smith">
                                        <div class="user-profile">
                                            <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">
                                                Jane Smith
                                            </div>
                                            <div class="user-more">
                                                Hello you there?
                                            </div>
                                        </div>
                                        <div class="user-details-status-wrapper">
                                            <span class="badge badge-important">3</span>
                                        </div>
                                        <div class="user-details-count-wrapper">
                                            <div class="status-icon green"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="user-details-wrapper" data-chat-status="busy" data-chat-user-pic="" data-chat-user-pic-retina="" data-user-name="David Nester">
                                        <div class="user-profile">
                                            <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">
                                                David Nester
                                            </div>
                                            <div class="user-more">
                                                Busy, Do not disturb
                                            </div>
                                        </div>
                                        <div class="user-details-status-wrapper">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="user-details-count-wrapper">
                                            <div class="status-icon red"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="side-widget">
                            <div class="side-widget-title">more friends</div>
                            <div class="side-widget-content" id="friends-list">
                                <div class="user-details-wrapper" data-chat-status="online" data-chat-user-pic="" data-chat-user-pic-retina="" data-user-name="Jane Smith">
                                    <div class="user-profile">
                                        <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">
                                            Jane Smith
                                        </div>
                                        <div class="user-more">
                                            Hello you there?
                                        </div>
                                    </div>
                                    <div class="user-details-status-wrapper">

                                    </div>
                                    <div class="user-details-count-wrapper">
                                        <div class="status-icon green"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="user-details-wrapper" data-chat-status="busy" data-chat-user-pic="" data-chat-user-pic-retina="" data-user-name="David Nester">
                                    <div class="user-profile">
                                        <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">
                                            David Nester
                                        </div>
                                        <div class="user-more">
                                            Busy, Do not disturb
                                        </div>
                                    </div>
                                    <div class="user-details-status-wrapper">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="user-details-count-wrapper">
                                        <div class="status-icon red"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="user-details-wrapper" data-chat-status="online" data-chat-user-pic="" data-chat-user-pic-retina="" data-user-name="Jane Smith">
                                    <div class="user-profile">
                                        <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">
                                            Jane Smith
                                        </div>
                                        <div class="user-more">
                                            Hello you there?
                                        </div>
                                    </div>
                                    <div class="user-details-status-wrapper">

                                    </div>
                                    <div class="user-details-count-wrapper">
                                        <div class="status-icon green"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="user-details-wrapper" data-chat-status="busy" data-chat-user-pic="" data-chat-user-pic-retina="" data-user-name="David Nester">
                                    <div class="user-profile">
                                        <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">
                                            David Nester
                                        </div>
                                        <div class="user-more">
                                            Busy, Do not disturb
                                        </div>
                                    </div>
                                    <div class="user-details-status-wrapper">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="user-details-count-wrapper">
                                        <div class="status-icon red"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chat-window-wrapper" id="messages-wrapper" style="display:none">
                        <div class="chat-header">
                            <div class="pull-left">
                                <input type="text" placeholder="search">
                            </div>
                            <div class="pull-right">
                                <a href="#" class="" ><div class="iconset top-settings-dark "></div> </a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="chat-messages-header">
                            <div class="status online"></div><span class="semi-bold">Jane Smith(Typing..)</span>
                            <a href="#" class="chat-back"><i class="icon-custom-cross"></i></a>
                        </div>
                        <div class="chat-messages scrollbar-dynamic clearfix">
                            <div class="inner-scroll-content clearfix">
                                <div class="sent_time">Yesterday 11:25pm</div>
                                <div class="user-details-wrapper " >
                                    <div class="user-profile">
                                        <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                    </div>
                                    <div class="user-details">
                                        <div class="bubble">
                                            Hello, You there?
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="sent_time off">Yesterday 11:25pm</div>
                                </div>
                                <div class="user-details-wrapper ">
                                    <div class="user-profile">
                                        <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                    </div>
                                    <div class="user-details">
                                        <div class="bubble">
                                            How was the meeting?
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="sent_time off">Yesterday 11:25pm</div>
                                </div>
                                <div class="user-details-wrapper ">
                                    <div class="user-profile">
                                        <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                                    </div>
                                    <div class="user-details">
                                        <div class="bubble">
                                            Let me know when you free
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="sent_time off">Yesterday 11:25pm</div>
                                </div>
                                <div class="sent_time ">Today 11:25pm</div>
                                <div class="user-details-wrapper pull-right">
                                    <div class="user-details">
                                        <div class="bubble sender">
                                            Let me know when you free
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="sent_time off">Sent On Tue, 2:45pm</div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-input-wrapper" style="display:none">
                            <textarea id="chat-message-input" rows="1" placeholder="Type your message"></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- END CHAT -->
            <!-- END CONTAINER -->

            <!-- END PLANTILLA -->
            <!--
            <?php /*
              Por si se quieren poner las migas de pan
              Breadcrumbs::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
              ])
             */ ?>
            -->

<?php $this->endBody() ?>

    </body>
</html>


<?php $this->endPage() ?>
