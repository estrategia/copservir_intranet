<?php

use yii\helpers\Html;
use app\assets\TarjetaMasAsset;
use app\modules\intranet\models\MenuPortales;
use app\modules\tarjetamas\models\UsuarioTarjetaMas;

TarjetaMasAsset::register($this);

// Rutas imagenes
$srcLogo = Yii::$app->homeUrl . 'img/multiportal/tarjetamas/logo-tarjeta-mas.png';
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
                <div class="white-piece tarjetamas"></div>
                <div class="container">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?= Html::a("<img src='$srcLogo' width='200'>", ['/tarjetamas/sitio/index'], ['class' => 'navbar-brand tarjetamas']) ?>
                    </div>

                        <!--menu viejo-->
                    <!--<div id="navbar" class="navbar-collapse collapse tarjeta-mas">
                        <ul class="nav navbar-nav">
                            <li class="active">
                                <?= Html::a('Tarjeta M&aacute;s', ['/tarjetamas/sitio/informacion']) ?>
                                <ul class="submenu sub-tarjetamas">
                                    <li class="active"><?= Html::a('Términos y condiciones', ['/tarjetamas/sitio/terminos']) ?></li>
                                    <li class="active"><?= Html::a('Política de privacidad', ['/tarjetamas/sitio/politicas']) ?></li>
                                </ul>
                            </li>
                            <li class="active"> <?= Html::a('Preguntas frecuentes', ['/tarjetamas/sitio/preguntas']) ?></li>
                            <li class="active"> <?= Html::a('PQRS', ['/tarjetamas/sitio/atencion']) ?></li>
                            <li class="active">
                                <?php if (\Yii::$app->user->isGuest || !\Yii::$app->user->identity->tienePermiso(\Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'])): ?>
                                    <?= Html::a('Mi cuenta', "#") ?>
                                    <ul class="submenu sub-tarjetamas">
                                        <li class="active"><?= Html::a('Iniciar Sesión', ['/tarjetamas/usuario/autenticar']) ?></li>
                                        <li class="active"><?= Html::a('Registrarse', ['/tarjetamas/usuario/registro']) ?></li>
                                    </ul>
                                <?php else: ?> 
                                    <?php $model = UsuarioTarjetaMas::findOne(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento]) ?>
                                    <?php $nombre = explode(" ", $model->nombres); ?>
                                    <?= Html::a("Hola " . $nombre[0], ['/tarjetamas/usuario']) ?>
                                <?php endif; ?>
                            </li>
                            <?php MenuPortales::generarMenu(Yii::$app->controller->module->id) ?>
                        </ul>
                    </div> --> 


                    <!--Menu nuevo-->
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                            <?= Html::a('Tarjeta M&aacute;s <span class="caret"></span>', ['/tarjetamas/sitio/informacion'],
                                        ['class'=>'dropdown-toggle','data-toggle'=>'dropdown']) ?>
                              <ul class="dropdown-menu tarjetaMas">
                                <li><?= Html::a('Términos y condiciones', ['/tarjetamas/sitio/terminos']) ?></li>
                                <li><?= Html::a('Política de privacidad', ['/tarjetamas/sitio/politicas']) ?></li>
                              </ul>
                            </li>
                            <li><?= Html::a('Preguntas frecuentes', ['/tarjetamas/sitio/preguntas']) ?></li>
                            <li><?= Html::a('PQRS', ['/tarjetamas/sitio/atencion']) ?></li></li>
                            <li class="dropdown">
                            <?= Html::a('Mi cuenta <span class="caret"></span>', ['/tarjetamas/sitio/informacion'],
                                        ['class'=>'dropdown-toggle','data-toggle'=>'dropdown']) ?>
                              <ul class="dropdown-menu tarjetaMas">
                                <li><?= Html::a('Iniciar Sesión', ['/tarjetamas/usuario/autenticar']) ?></li>
                                <li><?= Html::a('Registrarse', ['/tarjetamas/usuario/registro']) ?></li>
                              </ul>
                            </li>

                            <?php MenuPortales::generarMenu(Yii::$app->controller->module->id) ?>
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
            <div class="footer-top footer-tarjeta-mas">
                <div class="container marketing">
                    <div class="row">
                        <div class="col-sm-4">
                            <img class="img-responsive" src="<?= "" . $srcLogo ?>" alt="Tarjeta más">
                            <p>Tarjeta más un producto exclusivo de Copservir, que comercializa bajo la marca comercial La Rebaja Droguerías y Minimarkets.</p>
                        </div>
                        <div class="col-sm-4">
                            <h3 style="color:#5A5A5A ;">&nbsp;</h3>
                            <div class="space-1"></div>
                            <p><i class="fa fa-caret-right"></i> <?= Html::a('Terminos y condiciones', ['/tarjetamas/sitio/terminos']) ?></p>
                            <p><i class="fa fa-caret-right"></i> <?= Html::a('Políticas de privacidad', ['/tarjetamas/sitio/politicas']) ?></p>

                        </div>
                        <div class="col-sm-4">
                            <h3 style="color:#5A5A5A ;">Contáctanos</h3>
                            <div class="space-1"></div>
                            <p>Call Center 018000 93 99 00 <br>                  
                                <?= Html::a('<span style="text-decoration:underline;"> PQRS ( Preguntas, Quejas, Reclamos y Sugerencias)</span>', ['/tarjetamas/sitio/atencion']) ?>
                            </p>    
                            <!--<ul class="redes">
                              <a href="https://www.facebook.com/copservir.ltda" target="_BLANK"><li class="facebook"><i class="fa fa-facebook"></i></li></a>
                              <a href="https://twitter.com/copservir" target="_BLANK"><li class="twitter"><i class="fa fa-twitter"></i></li></a>
                              <a href="https://www.youtube.com/CopservirLtda" target="_BLANK"><li class="youtube"><i class="fa fa-youtube"></i></li></a>
                            </ul>-->
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
