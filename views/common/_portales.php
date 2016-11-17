<?php
use yii\helpers\Html;
$src = Yii::$app->homeUrl . 'img/multiportal/copservir/';
?>

<!-- -->
<section id="carousel-clients">
  <div class="container internal">
    <div class="space-1"></div>
    <!-- <div id="owl-portales" class="owl-carousel"> -->

    <div class="col-md-4">
      <?= Html::a('<img class="img-responsive" style="margin:0 auto;" src="'.$src.'intranet.PNG" alt="">', ['/intranet/sitio/index'])?>
      <p style="font-weight:bolder;">Intranet</p>      
    </div>

    <div class="col-md-4">
      <?= Html::a('<img class="img-responsive" style="margin:0 auto;" src="'.$src.'trabajo-social.PNG" alt="">', 'http://intranet2.copservir.com/fundacion/')?>
      <p style="font-weight:bolder;">Responsabilidad Social</p> 
    </div>
    
    <div class="col-md-4">
      <?= Html::a('<img class="img-responsive" style="margin:0 auto;" src="'.$src.'proveedor.PNG" alt="">', 'http://intranet2.copservir.com/proveedores/')?>
      <p style="font-weight:bolder;">Proveedores</p> 
    </div>

     <!--  <div class="item dodgerBlue">
          <a href="#" ><img src="http://placehold.it/200x150" alt=""></a>
      </div>

      <div class="item skyBlue">
        <img src="http://placehold.it/200x150" alt="">
      </div>

      <div class="item zombieGreen">
        <img src="http://placehold.it/200x150" alt="">
      </div>

      <div class="item violet">
        <img src="http://placehold.it/200x150" alt="">
      </div>

      <div class="item yellowLight">
        <img src="http://placehold.it/200x150" alt="">
      </div>

      <div class="item steelGray">
        <img src="http://placehold.it/200x150" alt="">
      </div> -->

    <!-- </div> -->
  </div>
      <div class="space-2"></div>
</section>
