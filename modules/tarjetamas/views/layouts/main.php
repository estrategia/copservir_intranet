<?php
use yii\helpers\Html;
use app\assets\TarjetaMasAsset;
use app\modules\intranet\models\MenuPortales;

TarjetaMasAsset::register($this);

// Rutas imagenes
$srcLogo = Yii::$app->homeUrl . 'img/multiportal/tarjetamas/logo-tarjeta-mas.png';

$menuPortales = MenuPortales::traerMenuPortalesIndex(Yii::$app->controller->module->id);
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
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <?= Html::a("<img src='$srcLogo' width='200'>", ['/tarjetamas/sitio/index'],['class'=>'navbar-brand']) ?>
          </div>
          <div id="navbar" class="navbar-collapse collapse tarjeta-mas">
            <ul class="nav navbar-nav">
              <li class="active"> <?= Html::a('Inicio', ['/tarjetamas/sitio/index']) ?></li>
              <li class="active"> <?= Html::a('Tarjeta M&aacute;s', ['/tarjetamas/sitio/informacion']) ?>
                  <ul class="submenu sub-tarjetamas">
                      <li class="active"><?= Html::a('Términos y condiciones', ['/tarjetamas/sitio/terminos']) ?></li>
                      <li class="active"><?= Html::a('Política de privacidad', ['/tarjetamas/sitio/politicas']) ?></li>
                  </ul>
              </li>           
              <li class="active"> <?= Html::a('Mi cuenta', "#") ?></li>
              <li class="active"> <?= Html::a('Preguntas frecuentes', ['/tarjetamas/sitio/preguntas']) ?></li>
              <li class="active"> <?= Html::a('Atenci&oacute;n al cliente', ['/tarjetamas/sitio/atencion']) ?></li>
              <?php foreach ($menuPortales as $itemMenu): ?>
                <li>
                  <?php if ($itemMenu->esExterno()): ?>
                    <?= "<a href='$itemMenu->urlMenu' target='_blank'> <i class='$itemMenu->icono'></i> <span class='title'>$itemMenu->nombre</span> <span class='selected'></span> </a>" ?>
                  <?php else: ?>
                      <?= Html::a('<i class="'.$itemMenu->icono.'"></i> <span class="title">'.$itemMenu->nombre.'</span> <span class="selected"></span>', [ 'contenido?menu='.$itemMenu->urlMenu], []) ?>
                  <?php endif; ?>
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
      <div class="footer-top company-bgcolor-1">
        <div class="container marketing">
          <div class="row">
            <div class="col-sm-4">
              <div><img src=<?= "" . $srcLogo ?> alt=""></div>              
              <p>Tarjeta más un producto exclusivo de Copservir, que comercializa la bajo la marca comercial La Rebaja Droguerías y Minimarkets. </p>
            </div>
            <div class="col-sm-5">
              <h3>Menú</h3>
              <div class="col-md-6">
                <ul>
                  <li><?= Html::a('Inicio', ['/tarjetamas/sitio/index']) ?></li>
                  <li><?= Html::a('Tarjeta m&aacute;s', ['/tarjetamas/sitio/informacion']) ?></li>
                  <li><?= Html::a('Terminos y condiciones', ['/tarjetamas/sitio/terminos']) ?></li> 
                  <li><?= Html::a('Políticas de privacidad', ['/tarjetamas/sitio/politicas']) ?></li>                   
                </ul>   
              </div>
              <div class="col-md-6">
                <ul>
                  <li><?= Html::a('Mi cuenta', "#") ?></li>
                  <li><?= Html::a('Preguntas frecuentes', ['/tarjetamas/sitio/preguntas']) ?></li>
                  <li><?= Html::a('Atenci&oacute;n al cliente', "#") ?></li>
                </ul>  
              </div>
            </div>
            <div class="col-sm-3">
              <h3>Contácto</h3>
              <ul>
                <li>contacto@copservir.co</li>
                <li>(57) 1234567123</li>
                <li>Dirección</li>
              </ul>
              <ul class="redes">
                <a href="https://www.facebook.com/copservir.ltda" target="_BLANK"><li class="facebook"><i class="fa fa-facebook"></i></li></a>
                <a href="https://twitter.com/copservir" target="_BLANK"><li class="twitter"><i class="fa fa-twitter"></i></li></a>
                <a href="https://www.youtube.com/CopservirLtda" target="_BLANK"><li class="youtube"><i class="fa fa-youtube"></i></li></a>
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



