<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);

// Rutas imagenes
$srcLogo = Yii::$app->homeUrl . 'img/multiportal/proveedores/logo-proveedores.png';
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!-- ESTILOS DE LA PLANTILLA  -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?= Yii::getAlias('@web') ?>/css/multiportal/style.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web') ?>/css/multiportal/main.css" rel="stylesheet">
    <!-- Owl Carousel Assets -->
    <link href="<?= Yii::getAlias('@web') ?>/libs/multiportal/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web') ?>/libs/multiportal/owl-carousel/owl.theme.css" rel="stylesheet">

    <?php $this->head() ?>
    <script> requestUrl = "<?= Yii::$app->getUrlManager()->getBaseUrl() ?>";</script>

  </head>
  <body>
    <?php $this->beginBody() ?>
    <!-- NAVBAR
================================================== -->
    <div class="navbar-wrapper">

        <nav class="navbar navbar-coop navbar-static-top company-bgcolor-1">
          <div class="white-piece"></div>
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><img src=<?= "" . $srcLogo ?> alt=""></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"> <?= Html::a('Inicio', ['index']) ?></li>
              </ul>
            </div>
          </div>
        </nav>
    </div>

    <div id="container">
        <?= $content ?>

    </div>

    <!-- FOOTER -->
          <footer>
          <div class="footer-top company-bgcolor-1">
            <div class="container marketing">
              <div class="row">
                <div class="col-sm-3">
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
                  <div class="logo-bottom">
                    <img src=<?= "" . $srcLogo ?> alt="">
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

      <!-- JavaScript de las plantillas
   ================================================== -->
   <script>window.jQuery || document.write('<script src="<?= Yii::getAlias('@web') ?>/js/multiportal/vendor/jquery.min.js"><\/script>')</script>
    <script src="<?= Yii::getAlias('@web') ?>/libs/multiportal/owl-carousel/owl.carousel.min.js"></script>
    <script>

    $(document).ready(function($) {
      $("#owl-example").owlCarousel();
    });

    </script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?= Yii::getAlias('@web') ?>/js/multiportal/timeline.js"></script>
    <script src="<?= Yii::getAlias('@web') ?>/js/multiportal/vendor/holder.min.js"></script>
    <script src="<?= Yii::getAlias('@web') ?>/js/multiportal/main.js"></script>


    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
