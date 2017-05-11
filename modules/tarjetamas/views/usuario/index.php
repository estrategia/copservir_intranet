<?php
use yii\helpers\Html;
$this->title = 'Tarjeta Mas';
?>

<div class="container">
  <div class="space-2"></div>
  <div class="space-2"></div>
  <div class="row">
    <div class="col-md-12">
      
      
        <div class="col-md-3" style="">
          <ul class="nav nav nav-pills nav-stacked" role="tablist">
            <li role="presentation" class="active">
              <?=   Html::a('Actualizar datos', ['actualizar-datos'],['aria-controls' => "ver-tarjetas", ]);?>
            </li>
            <li role="presentation">
              <?=   Html::a('Ver tarjetas', ['mis-tarjetas'],['aria-controls' => "ver-tarjetas", ]);?>
            </li>
            <?php  /*
            <li role="presentation">
                <?=   Html::a('Activar tarjeta', ['activar-tarjeta'],['aria-controls' => "ver-tarjetas", ]);?> 
            </li>*/ ?>
            <li role="presentation">
              <?=   Html::a('Cerrar sesión', ['salir'],['aria-controls' => "ver-tarjetas", ]);?>
            </li>
          </ul>
        </div>
      

    </div>
  </div>
</div>
