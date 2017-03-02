<?php use yii\web\View; ?>
<?php $limite = Yii::$app->params['imagenesModuloGaleria']['limiteVisualizar']; ?>
<?php $indice = 1; ?>
<?php $tamanio = sizeof($objModulo->imagenesGaleria) ?>
<div class="space-2"></div>
<div class="space-1"></div>
<div class="flexbox-row">
  <?php foreach ($objModulo->imagenesGaleria as $imagen): ?>
    <div class="flexbox-col" style=" <?php if($indice > $limite) { echo "display: none;"; } ?> " >
      <a class="lightbox" href="<?= $imagen->getUrlImagen() ?>">
        <div class="slide-front ha slide">
            <div class="overlayer bottom-left fullwidth" style="<?php echo  $indice < $limite ? "display: none" : ""; ?>">
                <div class="overlayer-wrapper">
                    <div class="p-l-20 p-r-20 p-b-20 p-t-20" style="text-align:center;">
                        <h1 style="color:#fff !important;line-height:37px;background-color: rgba(0, 0, 0, 0.17)"><span class="semi-bold"> +<?php echo $tamanio - $indice; ?> </span></h1>
                    </div>
                </div>
            </div>
            <img class="img-thumbnail" src="<?= $imagen->getUrlImagen() ?>">
        </div>
      </a>
    </div>
    <?php $indice++; ?>
  <?php endforeach ?>
</div>

<?php $this->registerJs("jQuery('.lightbox').lightbox();", View::POS_READY); ?>