<?php
use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<?php foreach($tareasUsuario as $tarea):?>
  <tr>
    <td class="v-align-middle">
      <div class="checkbox check-default">
        <?= Html::a('<li class="fa fa-pencil-square-o"></li>', ['actualizar', 'id' => $tarea->idTarea], []) ?>
        <a href='#' data-tarea= "<?= $tarea->idTarea?>" data-location='0' data-role='inactivarTarea'>
          <li class="fa fa-times"></li>
        </a>
      </div>
    </td>
    <td class="v-align-middle"><?=$tarea->titulo ?></td>
    <td class="v-align-middle"><span class="muted"><?= $tarea->descripcion ?></span>
    </td>
    <td>
      <?= $tarea->objPrioridadTareas->nombre?>
    </td>
    <td><span class="muted"><?= $tarea->fechaEstimada ?></span>
    </td>
    <td class="v-align-middle">

      <div class="slider primary col-md-8">
        <div class="slider slider-horizontal" >

          <div class="tooltip top hide" >
            <div class="tooltip-arrow"></div>
            <div class="tooltip-inner"></div>
          </div>
          <input type="text" class="slider-element form-control" data-tarea="<?= $tarea->idTarea ?>" data-role="slider-tarea" value="" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?= $tarea->progreso?>" data-slider-orientation="horizontal" data-slider-selection="after" data-slider-tooltip="hide">
        </div>
      </div>
    </td>
  </tr>
<?php endforeach; ?>
