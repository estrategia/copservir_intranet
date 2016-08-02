<?php

use yii\helpers\Html;
use app\assets\MultiportalAsset;
use app\modules\intranet\models\MenuPortales;

MultiportalAsset::register($this);

// Rutas imagenes
$srcLogo = Yii::$app->homeUrl . 'img/multiportal/copservir/logo.png';
$srcLogoFooter = Yii::$app->homeUrl . 'img/multiportal/copservir/logo-footer.jpg';
$srcFb = Yii::$app->homeUrl . 'img/multiportal/copservir/fb.png';
$srcTw = Yii::$app->homeUrl . 'img/multiportal/copservir/tw.png';
$srcYt = Yii::$app->homeUrl . 'img/multiportal/copservir/yt.png';
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
        <link rel="stylesheet" href="<?= Yii::$app->homeUrl . 'libs/font-awesome/css/font-awesome.min.css'; ?>">
    </head>
    <body>
        <?php $this->beginBody() ?>
        <!-- NAVBAR -->
        <div class="navbar-wrapper">

            <nav class="navbar navbar-coop navbar-static-top">
                <div class="white-piece"></div>
                <div class="container coop">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?= Html::a("<img src='$srcLogo'>", ['/copservir/sitio/index'], ['class' => 'navbar-brand copservir']) ?>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                          <!--
                            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Page 1-1</a></li>
                                <li><a href="#">Page 1-2</a></li>
                                <li class="dropdown">
                                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1-2-1</a>
                                      <ul class="dropdown-menu level">
                                          <li><a href="#">Page 1-1</a></li>
                                          <li><a href="#">Page 1-2</a></li>
                                          <li><a href="#">Page 1-3</a></li>
                                      </ul>
                                </li>
                              </ul>
                            </li>
                            <li><?= Html::a('Page 2', ['#']) ?></li>
                            <li><?= Html::a('page 3', ['#']) ?></li>
                            <li><?= Html::a('Page 4', ['#']) ?></li>-->

                            <?= MenuPortales::generarMenu(Yii::$app->controller->module->id) ?>
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
            <div class="footer-top footer-copservir">
                <div class="container">
                    <div class="col-md-3">
                        <?= Html::a("<img src='$srcLogoFooter' class=''>", ['/copservir/sitio/index']) ?>
                        <div class="space-1"></div>
                    </div>
                    <div class="col-md-3">
                        <strong style="color:#fff;">Sede Copservir Barranquilla</strong>
                        <p>Calle 110 Av. Circunvalar No. 6R - 400 Teléfono (5) 328 8156</p>

                        <strong style="color:#fff;">Sede Copservir Bogotá</strong>
                        <p>Calle 13 No. 42 - 10 Teléfono (1) 3351700</p>
                    </div>

                    <div class="col-md-3">
                        <strong style="color:#fff;">Sede Copservir Bucaramanga</strong>
                        <p>Carrera 16 No. 47 - 82 Teléfono (7) 6309450 Fax: 6309490</p>
                        <strong style="color:#fff;">Sede Copservir Cali</strong>
                        <p>Calle 18 No. 121 - 130 Pance Teléfono (2) 3218000</p>
                    </div>
                    <div class="col-md-3">
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
