<?php

use yii\helpers\Html;
use app\assets\ProveedoresAsset;
use app\modules\intranet\models\MenuPortales;

ProveedoresAsset::register($this);

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
        <?php $this->head() ?>
        <script> requestUrl = "<?= Yii::$app->getUrlManager()->getBaseUrl() ?>";</script>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <!-- NAVBAR -->
        <div class="navbar-wrapper">

            <nav class="navbar navbar-coop navbar-static-top company-bgcolor-1">
                <div class="white-piece"></div>
                <div class="container proveedor">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?= Html::a("<img src='$srcLogo'>", ['/proveedores/sitio/index'], ['class' => 'navbar-brand copservir']) ?>
                    </div>

                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class=""> <?=  Html::a('Calendario', ['/proveedores/calendario']) ?></li>
                            <!--<li><?= Html::a('Page 2', ['#']) ?></li>
                            <li><?= Html::a('page 3', ['#']) ?></li>
                            <li><?= Html::a('Page 4', ['#']) ?></li>
                            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="#">element 1</a></li>
                                <li><a href="#">element 2</a></li>
                                <li><a href="#">element 3</a></li>
                                <li class="dropdown-submenu">
                                  <a href="#">element 4</a>
                                  <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="#">Second level</a></li>
                                    <li><a href="#">Second level</a></li>
                                    <li><a href="#">Second level</a></li>
                                  </ul>
                                </li>
                              </ul>
                            </li>-->
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

        <!-- JavaScript de las plantillas-->
        <script>window.jQuery || document.write('<script src="<?= Yii::getAlias('@web') ?>/js/multiportal/vendor/jquery.min.js"><\/script>')</script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
