<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use app\assets\IntranetAsset;

IntranetAsset::register($this);

$srcLogo = Yii::$app->homeUrl . 'img/logo_copservir.png';
//$srcFondo = Yii::$app->homeUrl . 'img/work.jpg';
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
  <body data-original=""  style="background-color: #1aab9c">
    <?php $this->beginBody() ?>
    <div class="container">
      <?=
      Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ])
      ?>
      <div class="row login-container animated fadeInUp">
        <div class="col-md-7 col-md-offset-2 tiles white no-padding">
          <p style="text-align:center;">
            <img class="" src=<?= "" . $srcLogo ?> alt="" data-src=<?= "" . $srcLogo ?> data-src-retina=<?= "" . $srcLogo ?> style="width: 317px;margin-top:21px;"/>
          </p>
          <?= $content ?>
        </div>
      </div>
    </div>

    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
