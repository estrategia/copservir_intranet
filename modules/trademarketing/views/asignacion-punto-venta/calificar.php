<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trademarketing\models\AsignacionPuntoVentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Califica un punto de venta';

?>
<div class="space-1"></div>
<div class="space-2"></div>

<div class="container">

		<center>
				<h2>LISTA DE CHEQUEO DE LA REVISIÓN EN PUNTOS DE VENTA PLUS</h2>
		</center>

		<div class="space-2"></div>

		<div class="col-md-12">

				<table class="table table-bordered" width="100%" >
					<tr>
							<td>
								PUNTO DE VENTA
							</td>
							<td>
								<?= $modeloAsignacion->idComercial.' - '.$modeloAsignacion->NombrePuntoDeVenta  ?>
							</td>
							<td>
								FECHA
							</td>
							<td>
								<?= date("Y-m-d");?>
							</td>
					</tr>
					<tr>
							<td>
								ADMON O SUB - ADMON
							</td>
							<td>
								<?= $modeloAsignacion->numeroDocumentoAdministradorPuntoVenta.', '.$modeloAsignacion->numeroDocumentosubAdministradorpuntoVenta  ?>
							</td>
							<td>
								# CHEQUEO
							</td>
							<td>
								<?= $modeloAsignacion->idAsignacion  ?>
							</td>
					</tr>
					<tr>
							<td>
								SUPERVISADO POR
							</td>
							<td>
								<?= $modeloAsignacion->numeroDocumento ?>
							</td>
							<td>
								FORMATO
							</td>
							<td>
								<?= $modeloAsignacion->nombreTipoNegocio ?>
							</td>
					</tr>
				</table>
		</div>
</div>

<div class="space-1"></div>
<div class="space-2"></div>
