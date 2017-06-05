<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use app\assets\IntranetAsset;

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
  <body data-original=""  style="background-color: #C4E1C4;">
    <?php $this->beginBody() ?>
    <div class="container">

          <?= $content ?>

    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
