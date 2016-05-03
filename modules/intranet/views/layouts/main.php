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
use nirvana\showloading\ShowLoadingAsset;

ShowLoadingAsset::register($this);
AppAsset::register($this);

$srcPictureUser = "''";
$userName = "";

if (!Yii::$app->user->isGuest) {
  $srcPictureUser = Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->imagenPerfil;
  $userName = Yii::$app->user->identity->alias;
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

  <link href="<?= Yii::getAlias('@web') ?>/libs/fullcalendar/fullcalendar.css" rel="stylesheet">
  <link href="<?= Yii::getAlias('@web') ?>/libs/boostrap-slider/css/slider.css" rel="stylesheet">
  <link href="<?= Yii::getAlias('@web') ?>/libs/pace/pace-theme-flash.css" rel="stylesheet">
  <link href="<?= Yii::getAlias('@web') ?>/libs/animate/animate.min.css" rel="stylesheet">
  <link href="<?= Yii::getAlias('@web') ?>/libs/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= Yii::getAlias('@web') ?>/libs/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet">
  <link href="<?= Yii::getAlias('@web') ?>/libs/webarch/webarch.css" rel="stylesheet">
  <link href="<?= Yii::getAlias('@web') ?>/css/site.css" rel="stylesheet">


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
            <li class="quicklinks"> <span class="h-seperate"></span></li>
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
                  <?php //= Html::a('Mis publicaciones &nbsp;&nbsp;<span class="badge badge-important animated bounceIn">2</span>', ['sitio/publicaciones']) ?>

                </li>
                <li class="divider"></li>
                <li>
                  <?= Html::beginForm(['usuario/salir'], 'post', ['id'=>'form-salir']); ?>
                  <?=  Html::submitButton('<i class="fa fa-power-off"></i> Salir', ['class' => 'btn btn-link']);?>
                  <?=  Html::endForm(); ?>
                </li>
              </ul>
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

          <li>
            <?= Html::a('<i class="fa fa-sitemap"></i> <span class="title">Menú corporativo</span> <span class="selected"></span>', ['sitio/menu'], []) ?>
          </li>

          <?php foreach ($menu as $subMenu): ?>
            <?php Menu::menuHtml($subMenu, $opciones->getOpcionesUsuario()); ?>
          <?php endforeach; ?>
        </ul>

        <!-- END SIDEBAR MENU -->
      </div>
    </div>
    <a href="#" class="scrollup">Scroll</a>
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
<script src="<?= Yii::getAlias('@web') ?>/libs/pace/pace.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/jquery-numberAnimate/jquery.animateNumbers.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/webarch/webarch.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/jquery-block-ui/jqueryblockui.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/jquery-unveil/jquery.unveil.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/jquery-ui-touch/jquery.ui.touch-punch.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/libs/boostrap-slider/js/bootstrap-slider.js"></script>

</body>
</html>


<?php $this->endPage() ?>
