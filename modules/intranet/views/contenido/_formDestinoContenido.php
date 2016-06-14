<?php

use yii\helpers\Html;
use kartik\select2\Select2;
?>
<?php $uid = uniqid(); ?>
<div class="row" id='<?= $uid ?>'>
  <div class="col-md-5">
    <?php echo Html::label('Grupo de Interés') ?>
    <?php
    echo Select2::widget([
      'name' => 'ContenidoDestino[idGrupoInteres][]',
      'id' => "grupo_$uid",
      'data' => $objContenidoDestino->getListaGrupoInteres($consultaTodos),
      'options' => ['placeholder' => 'Selecione ...'],
      'pluginOptions' => [
        'allowClear' => true
      ],
      'hideSearch' => false,
    ]);
    ?>
  </div>
  <div class="col-md-5">
    <?php echo Html::label('Ciudad') ?>
    <?php
    echo
    Select2::widget([
      'name' => 'ContenidoDestino[codigoCiudad][]',
      'value' => '',
      'id' => "ciudad_$uid",
      'data' => $objContenidoDestino->getListaCiudades($consultaTodos),
      'options' => ['placeholder' => 'Selecione ...'],
      'hideSearch' => false,
      'pluginOptions' => [
        'allowClear' => true
      ],
    ]);
    ?>
  </div>
  <div class="col-md-1">
    <?= Html::label('Quitar') ?>
    <?=
    Html::a('<i class = "fa fa-minus-square" ></i>', '#', [
      'data-role' => 'quitar-destino-contenido',
      'data-row' => "#$uid",
      'title' => 'Quitar'
    ]);
    ?>
  </div>

</div>
<br/>
