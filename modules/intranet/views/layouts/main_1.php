<?php

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
$srcLogo = Yii::$app->homeUrl . 'img/logo_copservir.png';

if (!Yii::$app->user->isGuest) {
  $srcPictureUser = Yii::$app->homeUrl . 'img/fotosperfil/' . \Yii::$app->user->identity->imagenPerfil;
  $userName = Yii::$app->user->identity->alias;
}


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
  <div class="header navbar navbar-inverse ">
    <div class="navbar-inner">

      <div class="header-seperation">
        <ul class="nav pull-left notifcation-center visible-xs visible-sm">
          <li class="dropdown">
            <a href="#main-menu" data-webarch="toggle-left-side">
              <div class="iconset top-menu-toggle-white"></div>
            </a>
          </li>
        </ul>
        <a href="index.html">
          <img src=<?= "" . $srcLogo ?> class="logo" alt=""  data-src="" data-src-retina="" style="margin: 6px 30px;
          width: 180px; position:relative"/>
        </a>
        <ul class="nav pull-right notifcation-center">
        </ul>
      </div>

      <div class="header-quick-nav" >
        <div class="pull-left">

          <ul class="nav quick-section">
            <li class="quicklinks">
              <a href="#" class="" id="layout-condensed-toggle" >
                <div class="iconset top-menu-toggle-dark"></div>
              </a>
            </li>
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
        <div class="pull-right">
          <div class="chat-toggler">

            <a href="#" class="dropdown-toggle" id="my-task-list" data-placement="bottom"  data-content='' data-toggle="dropdown" data-original-title="Notifications">
              <div class="user-details">
                <div class="username">
                  <span class="badge badge-important">3</span>
                  <span class="bold"><?= $userName ?></span>
                </div>
              </div>
              <div class="iconset top-down-arrow"></div>
            </a>

            <div id="notification-list" style="display:none">
              <div style="width:300px">
                <div class="notification-messages info">
                  <div class="user-profile">
                    <img src= <?= "" . $srcPictureUser ?> alt="" data-src="" data-src-retina="" width="35" height="35">
                  </div>
                  <div class="message-wrapper">
                    <div class="heading">
                      David Nester - Commented on your wall
                    </div>
                    <div class="description">
                      Meeting postponed to tomorrow
                    </div>
                    <div class="date pull-left">
                      A min ago
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="notification-messages danger">
                  <div class="iconholder">
                    <i class="icon-warning-sign"></i>
                  </div>
                  <div class="message-wrapper">
                    <div class="heading">
                      Server load limited
                    </div>
                    <div class="description">
                      Database server has reached its daily capicity
                    </div>
                    <div class="date pull-left">
                      2 mins ago
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="notification-messages success">
                  <div class="user-profile">
                    <img src=""  alt="" data-src="" data-src-retina="" width="35" height="35">
                  </div>
                  <div class="message-wrapper">
                    <div class="heading">
                      You haveve got 150 messages
                    </div>
                    <div class="description">
                      150 newly unread messages in your inbox
                    </div>
                    <div class="date pull-left">
                      An hour ago
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
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
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="page-container row">
    <div class="page-sidebar " id="main-menu">
      <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
        <div class="user-info-wrapper">
          <div class="profile-wrapper"> <img src=<?= "" . $srcPictureUser ?>  alt="" data-src="" data-src-retina="" width="69" height="69" /> </div>
          <div class="user-info">
            <div class="greeting">Bienvenido</div>
            <div class="username"> <span class="semi-bold"><?= $userName ?></span></div>
            <div class="status">Estado
              <a href="#">
                <div class="status-icon green"></div>
                Online
              </a>
            </div>
          </div>
        </div>

        <p class="menu-title">MENU</p>

        <ul>
          <li class="start  open active ">
            <?= Html::a('<i class="icon-custom-home"></i> <span class="title">Panel de control</span> <span class="selected"></span>', ['sitio/index'], []) ?>
          </li>
          <li>
            <?= Html::a('<i class="fa fa-list-alt"></i> <span class="title">Mis Publicaciones</span> <span class="selected"></span>', ['contenido/mis-publicaciones'], []) ?>
          </li>
          <li >
            <?= Html::a('<i class="fa fa-list-ul"></i> <span class="title">Tareas</span> <span class="selected"></span>', ['tareas/listar-tareas'], []) ?>
          </li>
          <li>
            <?= Html::a('<i class="fa fa-sitemap"></i> <span class="title">Organigrama</span> <span class="selected"></span>', ['sitio/organigrama'], []) ?>
          </li>
          <li>
            <?= Html::a('<i class="fa fa-calendar"></i> <span class="title">Calendario</span> <span class="selected"></span>', ['calendario/'], []) ?>
          </li>

          <?php foreach ($menu as $subMenu): ?>
            <?php Menu::menuHtml($subMenu, $opciones->getOpcionesUsuario()); ?>
          <?php endforeach; ?>

          <li>
            <?= Html::a('<i class="fa fa-sitemap"></i> <span class="title">Menú corporativo</span> <span class="selected"></span>', ['sitio/menu'], []) ?>
          </li>
        </ul>
      </div>
    </div>

    <a href="#" class="scrollup">Scroll</a>

    <div class="page-content">

      <div id="portlet-config" class="modal hide">
        <div class="modal-header">
          <button data-dismiss="modal" class="close" type="button"></button>
          <h3>Widget Settings</h3>
        </div>
        <div class="modal-body"> Widget settings form goes here </div>
      </div>

      <div class="clearfix"></div>

      <div class="content ">
        <div class="page-title"></div>
        <div id="container">
          <?= $content ?>
        </div>
      </div>

    </div>

    <?= $this->render('/sitio/_modalEnviarAmigo', []) ?>

    <?php $this->endBody() ?>
  </body>
  </html>
  <?php $this->endPage() ?>
