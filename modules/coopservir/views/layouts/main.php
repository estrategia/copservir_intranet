<?php
use yii\helpers\Html;
use app\assets\MultiportalAsset;
use app\modules\intranet\models\MenuPortales;

MultiportalAsset::register($this);

// Rutas imagenes
$srcLogo = Yii::$app->homeUrl . 'img/multiportal/copservir/logo-curva.jpg';
$srcLogoMovil = Yii::$app->homeUrl . 'img/multiportal/copservir/logo.png';
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

        <nav class="navbar navbar-coop navbar-static-top nav-green">  
          <div class="white-piece coop" style="border-radius: 0px;border: none;"></div>
          <div class="container-fluid coop">
            <div class="navbar-header" style="margin:0px !important;">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
                <?= Html::a("<img src='$srcLogo' class='logo-coop' style='height:80px;'>", ['/coopservir/sitio/index'],['class'=>'navbar-brand']) ?>
                <?= Html::a("<img src='$srcLogoMovil' class='logo-coop-movil'>", ['/coopservir/sitio/index'],['class'=>'navbar-brand']) ?>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><?= Html::a('Propósito', ['acerca-de']) ?></li>
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
        <div class="footer-top footer-copservir" style="height:438px;">
        <div class="container marketing">
            <div class="col-md-6">
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="space-2"></div>
                    <div class="col-md-12">
                      <strong style="color:#fff;">Sede Copservir Barranquilla</strong>
                      <p>Calle 110 Av. Circunvalar No. 6R - 400 Teléfono (5) 328 8156</p>
                    </div>
                    <div class="col-md-12">
                      <strong style="color:#fff;">Sede Copservir Bogotá</strong>
                      <p>Calle 13 No. 42 - 10 Teléfono (1) 3351700</p> 
                    </div>
                    <div class="col-md-12">
                      <strong style="color:#fff;">Sede Copservir Bucaramanga</strong>
                      <p>Carrera 16 No. 47 - 82 Teléfono (7) 6309450 Fax: 6309490</p>
                    </div>
                    <div class="col-md-12">
                      <strong style="color:#fff;">Sede Copservir Cali</strong>
                      <p>Calle 18 No. 121 - 130 Pance Teléfono (2) 3218000</p> 
                    </div>
                </div>             
              </div>
            
            <div class="col-md-3">
               <div class="space-2"></div>                
               <div class="contenedor-redes">
                    <strong style="color:#fff;">Nuestras</strong>
                    <p>Redes sociales</p> 
                    <p><i class="fa fa-facebook-official"></i> copservir</p>
                    <p><i class="fa fa-twitter"></i> @copservir</p>
                    <p><i class="fa fa-youtube-play"></i> copservirltda</p>
               </div>

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
