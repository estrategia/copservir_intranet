<?php use kartik\rating\StarRating; ?>
<div>
  <?php 
    echo StarRating::widget([
        'name' => 'rating_1',
        'value' => $datos['promedio'],
        'pluginOptions' => [
          'displayOnly' => true,
          'showClear'=> false,
          'showCaption' => false,
          'filledStar' => '<i class="glyphicon glyphicon-star"></i>',
          'emptyStar' => '<i class="glyphicon glyphicon-star-empty"></i>',
        ]
    ]);
  ?>
  <button class="btn btn-default btn-block" data-toggle="modal" data-target="#modal-form-calificacion" disabled>Valora este curso</button>
</div>