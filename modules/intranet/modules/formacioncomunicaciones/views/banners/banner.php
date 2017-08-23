<?php use yii\helpers\Url; ?>
<?php if (!empty($banner)): ?>
    <?php if ($banner[0]['urlEnlaceNoticia'] != ''): ?>
        <a href=" <?php echo Url::toRoute($banner[0]['urlEnlaceNoticia']); ?> ">
            <img class="img-responsive" src="<?= Yii::getAlias('@web').'/img/campanas/' . $banner[0]['rutaImagenResponsive'] ?>" alt="">
        </a>
    <?php else: ?>
            <img class="img-responsive" src="<?= Yii::getAlias('@web').'/img/campanas/' . $banner[0]['rutaImagenResponsive'] ?>" alt="">
    <?php endif ?>
<?php endif ?>
