<?= /* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */
$srcSlide = Yii::$app->homeUrl . 'img/multiportal/' . $this->context->module->id . '/slides/';
?>
<div id="myCarousel" class="carousel slide banner-copservir" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img class="img-responsive" src=<?=  $srcSlide . "banner-home.png" ?> alt="First slide">
        </div>
        <div class="item">
            <img class="img-responsive" src=<?=  $srcSlide . "banner-home.png" ?> alt="Second slide">
        </div>
        <div class="item">
            <img class="img-responsive" src=<?=  $srcSlide . "banner-home.png" ?> alt="Third slide">
        </div>
        <div class="item">
            <img class="img-responsive" src=<?=  $srcSlide . "banner-home.png" ?> alt="Third slide">
        </div> 
    </div>
</div>
<div class="container"> <!-- full section -->
    <div class="row">
        <div class="col-md-6">
            <img class="img-responsive" src=<?=  $srcSlide . "sectionplaceholder.png" ?> alt="">
        </div>
        <div class="col-md-6">
            <h2 style="color:#23B149;font-size: 38px;font-weight: bold;margin:0px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h2>

            <div class="space-1"></div>
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa fugiat rerum fuga voluptates delectus consectetur repellendus, quae, corrupti accusamus itaque laudantium excepturi aspernatur nisi eius.</p>
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla fugiat qui nemo, repudiandae itaque voluptas rem excepturi recusandae vel consequuntur iure, quas eaque alias? Explicabo, voluptates numquam facilis amet molestiae sed. Dolorum accusantium obcaecati, saepe dolorem cumque inventore sunt ratione.</p>
        </div>
    </div>
</div> 
<br><br>
<div class="row">
    
<?php echo $this->render('//common/_ultimasNoticias', [
        'contenidoModels' => $contenidoModels,
        'flagVerMas' => true,
        ]); ?>
</div>