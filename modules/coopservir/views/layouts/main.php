<?php
use yii\helpers\Html;
use app\assets\MultiportalAsset;
use app\modules\intranet\models\MenuPortales;

MultiportalAsset::register($this);

// Rutas imagenes
$srcLogo = Yii::$app->homeUrl . 'img/multiportal/copservir/logo.png';
$srcLogoFooter = Yii::$app->homeUrl . 'img/multiportal/copservir/logo-footer.jpg';
$srcFb =  Yii::$app->homeUrl . 'img/multiportal/copservir/fb.png';
$srcTw =  Yii::$app->homeUrl . 'img/multiportal/copservir/tw.png';
$srcYt =  Yii::$app->homeUrl . 'img/multiportal/copservir/yt.png';

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
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
    <!-- NAVBAR -->
    <div class="navbar-wrapper">

        <nav class="navbar navbar-coop navbar-static-top">
          <div class="white-piece"></div>
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
                <?= Html::a("<img src='$srcLogo'>", ['/coopservir/sitio/index'],['class'=>'navbar-brand']) ?>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><?= Html::a('Proposito', ['acerca-de']) ?></li>
                <li><?= Html::a('Visión', ['vision']) ?></li>                
                <li><?= Html::a('Historia', ['historia']) ?></li>
                <li><?= Html::a('Identidad', ['identidad']) ?></li>
                <li><?= Html::a('Compromiso social', ['compromiso']) ?></li>
                <li><?= Html::a('Gestión', ['gestion-ambiental']) ?></li>
                <li><?= Html::a('Sector cooperativo', ['sector-coperativo']) ?></li>
                <?php foreach (MenuPortales::traerMenuPortalesIndex(Yii::$app->controller->module->id) as $itemMenu): ?>
                  <li>
                    <?= $itemMenu->getHtmlLink(Yii::$app->controller->module->id) ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </nav>

    </div>

    <!-- CONTAINER -->
    <div id="container">
        <?= $content ?>
    </div>

    <!-- FOOTER -->
    <footer>
      <div class="footer-top">
        <div class="container marketing">
          <div class="row">
            <div class="col-sm-3">
              <img src=<?= "" . $srcLogoFooter ?> class="img-responsive" alt="Copservir">
              <div class="space-1"></div>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare commodo sagittis. Lorem ipsum dolor sit amet, consectetur.</p>
              <ul>
                <li>contacto@copservir.co</li>
                <li>(57) 1234567123</li>
                <li>Dirección</li>
              </ul>
            </div>
            <div class="col-sm-3">
              <h3>Menú</h3>
              <ul>
                <li>Quienes somos</li>
                <li>Proveedores</li>
                <li>Convenios empresariales</li>
                <li>Puntos de venta</li>
                <li>Contacto</li>
              </ul>
            </div>
            <div class="col-sm-3">
              <h3>Suscríbete</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ornare commodo sagittis. Lorem ipsum dolor sit amet, consectetur.</p>
              <form action="#" class="subscribe">
                <div class="form-group">
                  <div class="row not-marg">
                    <div class="col-sm-7 not-pad">
                      <input placeholder="Correo electrónico" id="correo" type="text">
                    </div>
                    <div class="col-sm-5 not-pad">
                      <button type="submit">Suscríbete</button>
                    </div>
                  </div>
                </div>

              </form>
            </div>
            <div class="col-sm-3">
              <ul class="redes">
                <li>
                  <img src=<?= "" . $srcFb ?>>
                </li>
                <li>
                  <img src=<?= "" . $srcTw ?>>
                </li>
                <li>
                  <img src=<?= "" . $srcYt ?>>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container marketing">
          <p>&copy; 2016 Copservir Ltda.</p>
        </div>
      </div>
    </footer>

    <!-- JavaScript de las plantillas-->
    <script>window.jQuery || document.write('<script src="<?= Yii::getAlias('@web') ?>/js/multiportal/vendor/jquery.min.js"><\/script>')</script>
    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
