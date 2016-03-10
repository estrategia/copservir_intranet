<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Calendario';
?>

<div class="row" style="max-height:600px;">
  <div class="tiles row tiles-container red no-padding">
    <div class="col-md-4 tiles red no-padding">
      <div class="tiles-body">
        <div class="calender-options-wrapper">
          <h3 class="text-white semi-bold" id="calender-current-day">Wednesday</h3>
          <h2 class="text-white" id="calender-current-date">Mar 2016</h2>
          <div id="external-events" class="hide-inphone events-wrapper">
            <div class="events-heading">&nbsp;Eventos del Día</div>
              <ul>
                  <li>Novena de Aguinaldos Area de Mercadeo</li>
                  <li>Foro automonitoreo de al Diabetes Espéralo mañana al medio dia!, inscríbete en http://ow.ly/QqLNY</li>
                  <li>Viernes de la Salud en <a href="www.larebajavirtual.com">www.larebajavirtual.com</a></li>
                  <li>Hoy!! Recibe un 30% de descuento en la 2da.unidad de los pañales Pequeñin de 30/50 unidades, www.larebajavirtual.com</li>
                </ul>


          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8 tiles white no-padding">
      <div class="tiles-body">
        <div class="full-calender-header">
          <div class="pull-left">
            <div class="btn-group ">
              <button class="btn btn-success" id="calender-prev"><i class="fa fa-angle-left"></i></button>
              <button class="btn btn-success" id="calender-next"><i class="fa fa-angle-right"></i></button>
            </div>
          </div>
          <div class="pull-right">
            <div data-toggle="buttons-radio" class="btn-group">
              <button class="btn btn-primary active" type="button" id="change-view-month">month</button>
              <button class="btn btn-primary " type="button" id="change-view-week">week</button>
              <button class="btn btn-primary" type="button" id="change-view-day">day</button>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div id="calendar" class="fc fc-ltr">
          <table class="fc-header" style="width: 100%; display: none;">
            <tbody>
              <tr>
                <td class="fc-header-left">
                  <span class="fc-header-space"></span>
                </td>
                <td class="fc-header-center">
                </td>
                <td class="fc-header-right">
                  <span class="fc-button fc-button-month fc-state-default fc-corner-left fc-state-active" unselectable="on">month</span>
                  <span class="fc-button fc-button-agendaWeek fc-state-default" unselectable="on">week</span>
                  <span class="fc-button fc-button-agendaDay fc-state-default fc-corner-right" unselectable="on">day</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
