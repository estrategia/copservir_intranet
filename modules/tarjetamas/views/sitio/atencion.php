<?php
use yii\helpers\Html;
$this->title = 'Atención al cliente';
$src = Yii::$app->homeUrl . 'img/multiportal/tarjetamas';
?>

<!-- colocar migas de pan -->
<div class="page-header">
   <div class="container">
      <div class="page-title">
        <h1>PQRS</h1>
        <div class="breadcrumbs"><?= Html::a('Inicio', ['/tarjetamas/sitio/index']) ?> / PQRS</div>
      </div>
   </div>
</div>

<div class="container">
  <section>
      <div class="space-2"></div>
      <div class="row">
         <!-- <div class="col-md-6">
              <div class="space-1"></div> 
              <h2 class="text-center">Si tienes alguna petición, queja, reclamo o sugerencia regístrala <?= Html::a('Aquí', ['#']) ?>.</h2>
          </div>
          <div class="col-md-6">
              <img width="400" class="img-responsive" src=<?= "" . $src . "/atencion-cliente.jpg" ?> alt="">
          </div>-->
         <div class="col-md-12">
             <iframe src="http://pqrs.copservir.com/pqrs/web/pqrsexterno/pqrs/index?sitio=3" align="middle" frameborder="0" height="400px" width="100%"></iframe>
         </div>
      </div> 
  </section>    
</div>

<div class="space-2"></div>
