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
                        <tr>
                            <td class="v-align-middle">
                              <div class="checkbox check-default">
			                          <input id="checkbox11" type="checkbox" value="1">
			                          <label for="checkbox11"></label>
								              </div>
                            </td>
                            <td class="v-align-middle">Enviar correo a Jaime para las firmas</td>
                            <td class="v-align-middle"><span class="muted">Contratos para la adquisición de servicios de Google Maps</span>
                            </td>
                            <td><span class="muted">2 hrs</span>
                            </td>
                            <td class="v-align-middle">
                                <div class="progress">
                                    <div data-percentage="79%" class="progress-bar progress-bar-success animate-progress-bar" style="width: 79%;"></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</div>
