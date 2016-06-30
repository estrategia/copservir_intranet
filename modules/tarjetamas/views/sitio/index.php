<?php
use yii\helpers\Html;

$this->title = 'Tarjeta Mas';

// Rutas imagenes
$srctarjetamas = Yii::$app->homeUrl . 'img/multiportal/tarjetamas';
?>

<div class="space-1"></div>
<div class="space-1"></div>
<div class="space-1"></div>
<div class="space-1"></div>
<div class="container-fluid">
    <div class="row">
          <img class="img-responsive" src="<?= "" . $srctarjetamas . "/banner-intranet-tarjeta-mas.jpg"?>" alt="Tarjeta más">  
    </div>

</div>
<div class="container internal">
  <section>  <!-- acerca de home -->
    <div class="acerca-home">
      <div class="space-1"></div>
      <div class="postIn">
        <h1 class="text-center">
            Ahora con la Tarjeta más tendrás la oportunidad de realizar tus compras con descuento en el momento en que lo necesites en la Rebaja Droguerías y Minimarkets.
        </h1>
        <h2 class="text-center" style="font-weight: bold;"><?= Html::a('Descubre cómo', ['/tarjetamas/sitio/informacion']) ?></h2>
      </div>
      <div class="space-2"></div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <div class="postLeft white-item">  
            <?= Html::a('<img class="img-responsive hover-img" src="'.$srctarjetamas.'/activa-tu-tarjeta.png"  alt="Activa tu tarjeta">', ['/tarjetamas/sitio/informacion']) ?>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="postIn white-item">
            <?= Html::a('<img class="img-responsive hover-img" src="'.$srctarjetamas.'/preguntas-frecuentes.png"  alt="preguntas frecuentes">', ['/tarjetamas/sitio/preguntas']) ?>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="postRight white-item">
            <?= Html::a('<img class="img-responsive hover-img" src="'.$srctarjetamas.'/atencion-al-cliente.png"  alt="atencion-al-cliente">', ['/tarjetamas/sitio/atencion']) ?>
        </div>
      </div>
    </div>

  </section> <!-- / acerca de home -->
</div>

<div class="space-2"></div>
<?php
 $this->registerJs("jQuery('.postIn').viewportChecker({classToAdd: 'visible animated bounceIn', offset: 100});", \yii\web\View::POS_END);
 $this->registerJs("jQuery('.postLeft').viewportChecker({classToAdd: 'visible animated bounceInLeft', offset: 100});", \yii\web\View::POS_END);
  $this->registerJs("jQuery('.postRight').viewportChecker({classToAdd: 'visible animated bounceInRight', offset: 100});", \yii\web\View::POS_END);
?>    

