<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Tareas';
?>

<div class="col-md-12">
    <div class="grid simple ">
        <div class="grid-title no-border" style="background-color: #0AA699 !important;">
            <h4 style='color:#fff !important;'>Administrar  <span class="semi-bold">Tareas</span></h4>
            <div class="tools">	<a href="javascript:;" class="collapse"></a>
				<a href="#grid-config" data-toggle="modal" class="config"></a>
				<a href="javascript:;" class="reload"></a>
				<a href="javascript:;" class="remove"></a>
            </div>
        </div>
        <div class="grid-body no-border">
              <h3>Tareas  <span class="semi-bold">Personales</span></h3>
              <?= Html::a('crear tarea', ['crear'], ['class'=>'btn btn btn-primary pull-right']) ?>
                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th style="width:1%">
                                <div class="checkbox check-default"></div>
                            </th>
                            <th style="width:9%">Título</th>
                            <th style="width:22%">Descripción</th>
                            <th style="width:6%">Fecha Estimada</th>
                            <th style="width:10%">Progreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($modelTareas as $tarea):?>
                        <tr>
                            <td class="v-align-middle">
                              <div class="checkbox check-default">
                                <?= Html::a('<li class="fa fa-pencil-square-o"></li>', ['actualizar', 'id' => $tarea->idTarea], []) ?>
                                <?= Html::a('<li class="fa fa-times"></li>', ['eliminar', 'id' => $tarea->idTarea], [
                                    'data' => [
                                        'confirm' => 'Estas seguro de querer eliminar esta tarea?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
								              </div>
                            </td>
                            <td class="v-align-middle"><?=$tarea->titulo ?></td>
                            <td class="v-align-middle"><span class="muted"><?= $tarea->descripcion ?></span>
                            </td>
                            <td><span class="muted"><?= $tarea->fechaEstimada ?></span>
                            </td>
                            <td class="v-align-middle">
                                <!--<div class="progress">
                                    <div data-percentage="79%" class="progress-bar progress-bar-success animate-progress-bar" style="width: 79%;"></div>
                                </div>-->
                                <div class="slider primary col-md-8">
						                      <div class="slider slider-horizontal" >
                                    <!--<div class="slider-track">
                                      <div class="slider-selection"></div>
                                      <div class="slider-handle round"></div>
                                      <div class="slider-handle round hide"></div>
                                    </div>-->
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
                    </tbody>
                </table>
        </div>
    </div>
</div>
