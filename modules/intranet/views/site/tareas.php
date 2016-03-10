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
                                <div class="checkbox check-default">
									<!--<input id="checkbox10" type="checkbox" value="1" class="checkall">
									<label for="checkbox10"></label>-->
								</div>
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
                        <!--<tr>
                            <td>
                                <div class="checkbox check-default">
									<input id="checkbox12" type="checkbox" value="1">
									<label for="checkbox12"></label>
								</div>
                            </td>
                            <td><div class="inline">Llamar a Martha!!</div> <span class="label label-important">Urgente!</span>
                            </td>
                            <td><span class="muted">Aplazar la entrega de los reportes de ventas</span>
                            </td>
                            <td><span class="muted">2 dias</span>
                            </td>
                            <td>
                                <div class="progress">
                                    <div data-percentage="10%" class="progress-bar progress-bar-danger animate-progress-bar" style="width: 10%;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox check-default">
									<input id="checkbox13" type="checkbox" value="1">
									<label for="checkbox13"></label>
								</div>
                            </td>
                            <td>Actualizar las campañas ASAP</td>
                            <td class="v-align-middle"><span class="muted">Poner al aire las campañas del 10 y 25 Cliente Fiel</span>
                            </td>
                            <td><span class="muted">1 hora</span>
                            </td>
                            <td>
                                <div class="progress">
                                    <div data-percentage="65%" class="progress-bar progress-bar-info animate-progress-bar" style="width: 65%;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox check-default">
									<input id="checkbox14" type="checkbox" value="1">
									<label for="checkbox14"></label>
								</div>
                            </td>
                            <td>Hacer Backup</td>
                            <td class="v-align-middle"><span class="muted">Solicitar el disco duro portatil para copiar las carpetas personales</span>
                            </td>
                            <td><span class="muted">1 semana</span>
                            </td>
                            <td>
                                <div class="progress ">
                                    <div data-percentage="42%" class="progress-bar progress-bar-warning animate-progress-bar" style="width: 42%;"></div>
                                </div>
                            </td>
                        </tr>-->
                    </tbody>
                </table>
        </div>
    </div>
</div>
