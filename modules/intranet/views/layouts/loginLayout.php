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

        <link href="<?= Yii::getAlias('@web') ?>/libs/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?= Yii::getAlias('@web') ?>/libs/webarch/webarch.css" rel="stylesheet">
        <link href="<?= Yii::getAlias('@web') ?>/css/site.css" rel="stylesheet">
        <script> requestUrl = "<?= Yii::$app->getUrlManager()->getBaseUrl() ?>";</script>
    </head>
    <body data-original=""  style="background-image: url('<?= "" . $srcFondo ?>')">
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
