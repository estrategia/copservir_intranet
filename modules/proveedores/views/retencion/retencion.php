<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="container">
<h1>Certificado de Retención Anual</h1>

<?php 
	$form = ActiveForm::begin([
		//"options" => ["enctype" => "multipart/form-data"],
	]); 
	?>
		<div class="col-md-12">
			<?= $form->field($model, 'nit') ?>	
			<?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary']) ?>
			<br><br>	
		</div>
<?php ActiveForm::end(); ?>	

<?php if ($nitPost != NULL): ?>
<h4>Descargue los Certificados del NIT: <?=$nitPost?></h4>

<div class="panel panel-default">
  <div class="panel-heading">Certificados de Retención Anual</div>
  <div class="panel-body"> 
	<table class="table">
		<thead>
		  <tr>
			<th></th>
			<th>Descargar</th>
		  </tr>
		</thead>
		<tbody>
		  <tr>
			<td>Retención en la Fuente</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/retencion/periodo1/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>		
		  </tr>
		  <tr>
			<td>Retención CREE</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/cree/cree_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>		
		  </tr>
		  <tr>
			<td>Retención en la Fuente SASNET</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cr_sas_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>		
		  </tr>
		  <tr>
			<td>Retención CREE SASNET</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sas_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>			
		  </tr>	  
		</tbody>
	 </table>
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">Certificados de IVA bimestrales</div>
  <div class="panel-body"> 
	<table class="table">
		<thead>
		  <tr>
			<th></th>
			<th>Descargar</th>
		  </tr>
		</thead>
		<tbody>
		  <tr>
			<td>IVA ENERO - FEBRERO</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/iva/periodo1/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>				
		  </tr>
		  <tr>
			<td>IVA MARZO - ABRIL</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/iva/periodo2/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>				
		  </tr>
		  <tr>
			<td>IVA MAYO - JUNIO</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/iva/periodo3/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>			
		  </tr>
		  <tr>
			<td>IVA JULIO - AGOSTO</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/iva/periodo4/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>			
		  </tr>
		  <tr>
			<td>IVA SEPTIEMBRE - OCTUBRE</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/iva/periodo5/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>			
		  </tr>	
		  <tr>
			<td>IVA OCTUBRE ERP</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/iva/periodo5/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>			
		  </tr>
		  <tr>
			<td>IVA NOVIEMBRE - DICIEMBRE</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/iva/periodo6/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>			
		  </tr>
		  <tr>
			<td></td>
			<td></td>
		  </tr>
		  <tr>
			<td>IVA SASNET ENERO – FEBRERO</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/ci_sas_lapso_1_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>			
		  </tr>
		  <tr>
			<td>IVA SASNET MARZO – ABRIL</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/ci_sas_lapso_2_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>				
		  </tr>
		  <tr>
			<td>IVA SASNET MAYO – JUNIO</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/ci_sas_lapso_3_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>				
		  </tr>
		  <tr>
			<td>IVA SASNET JULIO – AGOSTO</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/ci_sas_lapso_4_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>				
		  </tr>	
		  <tr>
			<td>IVA SASNET SEPTIEMBRE – OCTUBRE</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/ci_sas_lapso_5_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>				
		  </tr>
		  <tr>
			<td>IVA SASNET NOVIEMBRE – DICIEMBRE</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/ci_sas_lapso_6_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>				
		  </tr>	  
		</tbody>
	 </table>	
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">Certificado de Industria y Comercio</div>
  <div class="panel-body"> 
	<table class="table">
		<thead>
		  <tr>
			<th>Ciudad</th>
			<th></th>
			<th>Descargar</th>
		  </tr>
		</thead>
		<tbody>
		  <tr>
			<td><strong>Barranquilla</strong></td>
			<td>ReteICA</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/barranquilla/periodo6/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td><strong>Bogotá</strong></td>
			<td>ReteICA | Enero - Febrero</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/bogota/periodo1/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>		
		  </tr>
		  <tr>
			<td><strong></strong></td>
			<td>ReteICA | Marzo - Abril</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/bogota/periodo2/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>	
		  </tr>
		  <tr>
			<td><strong></strong></td>
			<td>ReteICA | Mayo - Junio</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/bogota/periodo3/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>	
		  </tr>	
		  <tr>
			<td><strong></strong></td>
			<td>ReteICA | Julio - Agosto</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/bogota/periodo4/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>	
		  </tr>
		  <tr>
			<td><strong></strong></td>
			<td>ReteICA | Septiembre - Octubre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/bogota/periodo5/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>	
		  </tr>	  
		  <tr>
			<td><strong></strong></td>
			<td>ReteICA | OCTUBRE ERP</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/bogota/periodo5/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>	
		  </tr>
		  <tr>
			<td><strong></strong></td>
			<td>ReteICA | Noviembre - Diciembre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/bogota/periodo6/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>	
		  </tr>
		  <tr>
			<td><strong>Bucaramanga</strong></td>
			<td>ReteICA</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/bucaramanga/periodo1/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>	
		  </tr>	  
		  <tr>
			<td><strong>Cali</strong></td>
			<td>ReteICA</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones_erp/industria/cali/periodo1/<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>	
		  </tr>	
		  <tr>
			<td></td>
			<td></td>
			<td></td>
		  </tr>	
		  <tr>
			<td><strong>Barranquilla</strong></td>
			<td>ReteICA | SASNET Enero - Febrero</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbar_lapso_1_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	
		  <tr>
			<td></td>
			<td>ReteICA | SASNET Marzo-Abril</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbar_lapso_2_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	  
		  <tr>
			<td></td>
			<td>ReteICA | Mayo-Junio</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbar_lapso_3_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td></td>
			<td>ReteICA | Julio-Agosto</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbar_lapso_4_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	 
		  <tr>
			<td></td>
			<td>ReteICA | Septiembre-Octubre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbar_lapso_5_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	
		  <tr>
			<td></td>
			<td>ReteICA | Noviembre-Diciembre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbar_lapso_6_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	
		  <tr>
			<td><strong>Bogotá</strong></td>
			<td>ReteICA | SASNET Enero-Febrero</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sas_lapso_1_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td></td>
			<td>ReteICA | SASNET Marzo-Abril</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sas_lapso_2_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	  
		  <tr>
			<td></td>
			<td>ReteICA | Mayo-Junio</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sas_lapso_3_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td></td>
			<td>ReteICA | Julio-Agosto</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sas_lapso_4_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	 
		  <tr>
			<td></td>
			<td>ReteICA | Septiembre-Octubre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sas_lapso_5_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	
		  <tr>
			<td></td>
			<td>ReteICA | Noviembre-Diciembre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sas_lapso_6_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	
		  <tr>
			<td><strong>Bucaramanga</strong></td>
			<td>ReteICA | SASNET Enero-Febrero</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbuc_lapso_1_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td></td>
			<td>ReteICA | SASNET Marzo-Abril</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbuc_lapso_2_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	  
		  <tr>
			<td></td>
			<td>ReteICA | Mayo-Junio</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbuc_lapso_3_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td></td>
			<td>ReteICA | Julio-Agosto</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbuc_lapso_4_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	 
		  <tr>
			<td></td>
			<td>ReteICA | Septiembre-Octubre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbuc_lapso_5_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	
		  <tr>
			<td></td>
			<td>ReteICA | Noviembre-Diciembre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sasbuc_lapso_6_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td><strong>Cali</strong></td>
			<td>ReteICA | SASNET Enero-Febrero</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sascal_lapso_1_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td></td>
			<td>ReteICA | SASNET Marzo-Abril</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sascal_lapso_2_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	  
		  <tr>
			<td></td>
			<td>ReteICA | Mayo-Junio</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sascal_lapso_3_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>
		  <tr>
			<td></td>
			<td>ReteICA | Julio-Agosto</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sascal_lapso_4_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	 
		  <tr>
			<td></td>
			<td>ReteICA | Septiembre-Octubre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sascal_lapso_5_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	
		  <tr>
			<td></td>
			<td>ReteICA | Noviembre-Diciembre</td>
			<td><a href="http://intranet.copservir.com/reportes/pdf/proveedores/certificados/retenciones/cic_sascal_lapso_6_<?=$nitPost?>.pdf" class="btn btn-black" title="Descargar" target="_blank"><i class="fa fa-download"></i> </a></td>
		  </tr>	  
		</tbody>
	  </table>
  </div>
</div>  

<?php endif ?>
</div>