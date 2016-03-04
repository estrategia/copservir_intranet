<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$srcLogo = Yii::$app->homeUrl . 'img/logo_copservir.png';
$srcFondo = Yii::$app->homeUrl . 'img/work.jpg';


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
    </head>
    <body data-original=""  style="background-image: url('<?= "".$srcFondo ?>')">
        <?php $this->beginBody() ?>

        <div class="container">
              <?=
              Breadcrumbs::widget([
                  'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
              ])
              ?>
              <div class="row login-container animated fadeInUp">
                <div class="col-md-7 col-md-offset-2 tiles white no-padding">
                  <div style="text-align: -webkit-center;">
                      <img class="" src=<?= "".$srcLogo ?> alt="" data-src=<?= "".$srcLogo ?> data-src-retina=<?= "".$srcLogo ?> style="width: 450px;"/>
                  </div>
                  <div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
                    <h2 class="normal">
                      Ingresar Intranet
                    </h2>
                    <p>
                      Utilice sus credenciales de acceso...<br>
                    </p>
                  </div>
                  <div class="tiles grey p-t-20 p-b-20 no-margin text-black tab-content">

                    <?= $content ?>

                  </div>
                </div>
              </div>
          </div>

        <?php $this->endBody() ?>
    </body>
</html>

<?php $this->endPage() ?>
