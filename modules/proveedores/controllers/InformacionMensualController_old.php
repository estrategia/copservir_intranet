<?php

namespace app\modules\proveedores\controllers;
use Yii;
use yii\helpers\Html;
//use app\modules\proveedores\models\InformacionMensualSearch;

class InformacionMensualController extends \yii\web\Controller 
{
	
/*
	public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/proveedores/usuario/autenticar']
            ],

            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'index', 'productos_nuevos',
                ],
                'authsActions' => [
                    'index' => 'proveedores_usuario',
                'productos_nuevos' => 'proveedores_usuario',
                ],
           ],
        
        ];
    }
*/	
	public function actionIndex()
	{		
	$columnas = InformacionMensualController::createColumnsArray('AZ');
	$array_meses = array(
		1 => 'Enero',
		2 => 'Febrero',
		3 => 'Marzo',
		4 => 'Abril',
		5 => 'Mayo',
		6 => 'Junio',
		7 => 'Julio',
		8 => 'Agosto',
		9 => 'Septiembre',
		10 => 'Octubre',
		11 => 'Noviembre',
		12 => 'Diciembre'
	);
			
	$num_paginas = 0;
	$separador = ",";
	$maximo = 3000;
	$datos_prov = array();
	$cod_prov = "-1";
	$cod_prov_ext = "";
	$nom_prov = "";
	$bloqueo = false;		
	$mes = date("n", strtotime("-1 months"));
	$anho = date("Y", strtotime("-1 months"));
	$dia_fin_ant = date("d", strtotime('last day of previous month'));
	$interno = 1;
	$html = "";
	$fecha_rep = date("Y-m-d h:i:s");
	
	if(($fecha_rep >= date("Y-m-")."04 00:00:00" && $fecha_rep <= date("Y-m-")."31 23:59:59"))
	{		
		//Lista de proveedores bloqueados por codigo de proveedor
		$proveedoresBloqueados = array(3, 5, 6, 10, 18, 19, 21, 22, 25, 46, 47, 49, 51, 53, 54, 56, 58, 60, 61, 63, 64, 69, 72, 73, 79, 85, 91, 98, 101, 102, 106, 113, 122, 123, 125, 126, 130, 131, 133, 134, 135, 137, 142, 144, 145, 146, 149, 150, 151, 152, 159, 164, 167, 168, 169, 170, 173, 174, 178, 182, 187, 192, 193, 195, 196, 200, 205, 206, 207, 215, 218, 219, 220, 221, 223, 224, 225, 228, 229, 230, 233, 234, 236, 238, 243, 244, 249, 251, 252, 256, 260, 268, 269, 270, 273, 275, 276, 278, 281, 285, 289, 293, 295, 297, 301, 304, 305, 308, 313, 315, 316, 317, 318, 321, 324, 327, 328, 330, 331, 332, 339, 340, 341, 343, 347, 349, 350, 353, 358, 359, 360, 361, 362, 363, 369, 372, 373, 375, 376, 378, 381, 382, 386, 388, 390, 391, 393, 394, 395, 400, 401, 402, 404, 406, 408, 409, 410, 411, 413, 415, 417, 418, 420, 421, 423, 427, 429, 431, 433, 434, 435, 436, 437, 445, 448, 449, 450, 452, 455, 463, 465, 473, 475, 476, 477, 478, 479, 483, 484, 491, 492, 495, 498, 501, 514, 515, 516, 517, 518, 526, 529, 532, 533, 537, 538, 542, 544, 546, 549, 553, 558, 560, 561, 564, 565, 572, 577, 584, 593, 602, 608, 610, 611, 616, 619, 621, 636, 639, 649, 651, 658, 659, 670, 671, 673, 674, 677, 678, 681, 684, 685, 687, 688, 692, 694, 726, 728, 741, 742, 747, 753, 755, 756, 757, 761, 762, 763, 765, 766, 767, 769, 770, 771, 781, 782, 783, 784, 786, 787, 789, 792, 797, 804, 809, 820, 824, 828, 832, 838, 840, 844, 849, 850, 868, 873, 876, 880, 892, 896, 897, 898, 900, 906, 908, 911, 914, 917, 922, 923, 924, 925, 928, 935, 938, 940, 943, 947, 952, 953, 955, 957, 958, 960, 968, 973, 976, 980, 981, 983, 985, 986, 987, 988, 989, 991, 992, 997, 998, 1000, 1003, 1007, 1010, 1013, 1022, 1024, 1025, 1027);
		
		//Capturar el proveedor o ENVIAR PROVEDOR EN GET
		
		//Bloquear si el proveedor no tiene convenio para ver la información

		$bloqueo = "";
		if(in_array(2, $proveedoresBloqueados))
					$bloqueo = true;
			
		//Comsultamos los datos desde el modelo		
		$model = new \app\modules\proveedores\models\InformacionMensual();
		$datos = $model->datos();		
				
		if($bloqueo == false)
		{
			require_once("archivos_proveedores/assets/PHPExcel.php");
			include("archivos_proveedores/assets/PHPExcel/Writer/Excel2007.php");
	
			$fondo_gris = 'D8D8D8';
			$fondo_azul = '000066';
			$fondo_azul_claro = '004C99';
			$fondo_naranja = 'FF8000';
			$fondo_amarillo = 'FFFF33';
			$fondo_oro = 'FFD700';
			$fondo_verde = 'ADFF2F';
			$fondo_negro = '404040';
			$borde_celda = '666666';
			$borde_celda_negro = '000000';
			$texto_rojo = '990000';
			$texto_blanco = 'FFFFFF';
			$texto_negro = '000000';
			
			$array_rojo_header_ppal = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
				'font' => array('bold' => true, 'color' => array('rgb' => $texto_rojo), 'size'  => 16),
			);
			
			$array_gris_header = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda)),
				'fill' => array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $fondo_gris)),
				'font' => array('bold' => true),
			);
			
			$array_azul_header = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda_negro)),
				'fill' => array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $fondo_azul)),
				'font' => array('bold' => true, 'color' => array('rgb' => $texto_blanco)),
			);
			
			$array_azul_claro_header = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda_negro)),
				'fill' => array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $fondo_azul_claro)),
				'font' => array('bold' => true, 'color' => array('rgb' => $texto_blanco)),
			);
			
			$array_naranja_header = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda_negro)),
				'fill' => array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $fondo_naranja)),
				'font' => array('bold' => true),
			);
			
			$array_amarillo_header = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda_negro)),
				'fill' => array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $fondo_amarillo)),
				'font' => array('bold' => true),
			);
			
			$array_oro_header = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda_negro)),
				'fill' => array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $fondo_oro)),
				'font' => array('bold' => true),
			);
			
			$array_verde_header = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda_negro)),
				'fill' => array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $fondo_verde)),
				'font' => array('bold' => true),
			);
			
			$array_negro_header = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda_negro)),
				'fill' => array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => $fondo_negro)),
				'font' => array('bold' => true, 'color' => array('rgb' => $texto_blanco)),
			);

			$array_celda_centro = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda)),
			);

			$array_celda_izq = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda)),
			);

			$array_celda_der = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
				'borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN), 'color' => array('rgb' => $borde_celda)),
			);
		
			//Se leen los archivos csv
			$csv_invent = "inventarios_sucursal.csv";
			$csv_ventas = "ventas_sucursal.csv";
			
			$arr_invent = array();
			$arr_ventas = array();
			
			if(($handle = fopen("archivos_proveedores/csv/".$csv_invent, "r")) !== false)
			{
				
				while(($dato_csv = fgetcsv($handle, 0, $separador)) !== false)
				{
					if($cod_prov == trim($dato_csv[3]))
						$arr_invent[] = $dato_csv;
				}
				
				fclose($handle);
			}
			
			if(($handle = fopen("archivos_proveedores/csv/".$csv_ventas, "r")) !== false)
			{
				while(($dato_csv = fgetcsv($handle, 0, $separador)) !== false)
				{
					if($cod_prov == trim($dato_csv[3]))
						$arr_ventas[] = $dato_csv;
				}
				
				fclose($handle);
			}
			
			//Se genera el objeto y la cabecera en excel
			$objPHPExcel = new \PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setPrintGridlines(false);
			$objPHPExcel->getActiveSheet()->setShowGridlines(false);
			$objPHPExcel->getActiveSheet()->setTitle("INVENTARIOS SUCURSALES");
			$num_paginas++;
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');

			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'COPSERVIR LTDA');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'DIRECCION COMERCIAL');
			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'INVENTARIO NACIONAL '.strtoupper($array_meses[$mes]).' '.$dia_fin_ant.' DE '.$anho);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($array_rojo_header_ppal);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($array_rojo_header_ppal);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($array_rojo_header_ppal);
			
			$num_fila = 5;
			$objPHPExcel->getActiveSheet()->mergeCells('G'.$num_fila.':L'.$num_fila);
			$objPHPExcel->getActiveSheet()->mergeCells('M'.$num_fila.':R'.$num_fila);
			$objPHPExcel->getActiveSheet()->mergeCells('S'.$num_fila.':X'.$num_fila);
			$objPHPExcel->getActiveSheet()->mergeCells('Y'.$num_fila.':AD'.$num_fila);
			$objPHPExcel->getActiveSheet()->mergeCells('AE'.$num_fila.':AJ'.$num_fila);
			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$num_fila, 'BQUILLA');
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$num_fila, 'BOGOTA');
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$num_fila, 'BMANGA');
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$num_fila, 'CALI');
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$num_fila, 'NACIONAL');
			
			$objPHPExcel->getActiveSheet()->getStyle('G'.$num_fila)->applyFromArray($array_oro_header);
			$objPHPExcel->getActiveSheet()->getStyle('M'.$num_fila)->applyFromArray($array_verde_header);
			$objPHPExcel->getActiveSheet()->getStyle('S'.$num_fila)->applyFromArray($array_oro_header);
			$objPHPExcel->getActiveSheet()->getStyle('Y'.$num_fila)->applyFromArray($array_verde_header);
			$objPHPExcel->getActiveSheet()->getStyle('AE'.$num_fila)->applyFromArray($array_negro_header);
			
			$num_fila = 6;
			$columnas_tmp = InformacionMensualController::createColumnsArray('AJ');
			for($j=6; $j<=10; $j=$j+2)
			{
				$textos_tmp = array(
					6 => "CEDI",
					8 => "PUNTOS DE VENTA",
					10 => "TOTAL SUCURSAL",
				);
			
				for($i=$j; $i<sizeof($columnas_tmp); $i=$i+6)
				{
					$col1 = $columnas_tmp[$i];
					$col2 = $columnas_tmp[$i+1];
					
					$objPHPExcel->getActiveSheet()->mergeCells($col1.''.$num_fila.':'.$col2.''.$num_fila);
					$objPHPExcel->getActiveSheet()->setCellValue($col1.''.$num_fila, $textos_tmp[$j]);
				
					$objPHPExcel->getActiveSheet()->getStyle($col1.''.$num_fila)->applyFromArray($array_azul_claro_header);
				}
			}

			$num_fila = 7;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$num_fila, 'Codigo');
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$num_fila, 'Descripcion');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$num_fila, 'Presentacion');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$num_fila, 'CodProv');
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$num_fila, 'NomProveed');
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$num_fila, 'Division');
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$num_fila)->applyFromArray($array_gris_header);
			
			$columnas_tmp = InformacionMensualController::createColumnsArray('AJ');
			for($i=6; $i<sizeof($columnas_tmp); $i=$i+2)
			{
				$col1 = $columnas_tmp[$i];
				$col2 = $columnas_tmp[$i+1];
				$objPHPExcel->getActiveSheet()->setCellValue($col1.''.$num_fila, 'UND');
				$objPHPExcel->getActiveSheet()->setCellValue($col2.''.$num_fila, 'PESOS');
				
				$objPHPExcel->getActiveSheet()->getStyle($col1.''.$num_fila)->applyFromArray($array_azul_claro_header);
				$objPHPExcel->getActiveSheet()->getStyle($col2.''.$num_fila)->applyFromArray($array_azul_claro_header);
			}
			
			if(sizeof($arr_invent) > 0)
			{
				$num_fila = 8;
				foreach($arr_invent as $invent)
				{
					for($i=0; $i<sizeof($invent); $i++)
					{
						if(isset($invent[$i]) && $invent[$i] != "" && isset($columnas[$i]))
						{
							$col = $columnas[$i];
							$objPHPExcel->getActiveSheet()->setCellValue($col.''.$num_fila, $invent[$i]);
							$objPHPExcel->getActiveSheet()->getStyle($col.''.$num_fila)->applyFromArray($array_celda_izq);
						}
					}
					
					$num_fila++;
				}
			}
			
			//Hoja 2
			$objPHPExcel->createSheet(NULL, 1);
			$objPHPExcel->setActiveSheetIndex(1);
			$objPHPExcel->getActiveSheet()->setPrintGridlines(false);
			$objPHPExcel->getActiveSheet()->setShowGridlines(false);
			$objPHPExcel->getActiveSheet()->setTitle("VTAS SUCURSALES");
			$num_paginas++;
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');

			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'COPSERVIR LTDA');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'DIRECCION COMERCIAL');
			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'VENTAS DEL 01 AL '.$dia_fin_ant.' '.strtoupper($array_meses[$mes]).' DE '.$anho);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($array_rojo_header_ppal);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($array_rojo_header_ppal);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($array_rojo_header_ppal);
			
			$num_fila = 5;
			$objPHPExcel->getActiveSheet()->mergeCells('G'.$num_fila.':H'.$num_fila);
			$objPHPExcel->getActiveSheet()->mergeCells('I'.$num_fila.':J'.$num_fila);
			$objPHPExcel->getActiveSheet()->mergeCells('K'.$num_fila.':L'.$num_fila);
			$objPHPExcel->getActiveSheet()->mergeCells('M'.$num_fila.':N'.$num_fila);
			$objPHPExcel->getActiveSheet()->mergeCells('O'.$num_fila.':P'.$num_fila);
			
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$num_fila, 'BQUILLA');
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$num_fila, 'BOGOTA');
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$num_fila, 'BMANGA');
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$num_fila, 'CALI');
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$num_fila, 'NACIONAL');
			
			$objPHPExcel->getActiveSheet()->getStyle('G'.$num_fila)->applyFromArray($array_oro_header);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$num_fila)->applyFromArray($array_verde_header);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$num_fila)->applyFromArray($array_oro_header);
			$objPHPExcel->getActiveSheet()->getStyle('M'.$num_fila)->applyFromArray($array_verde_header);
			$objPHPExcel->getActiveSheet()->getStyle('O'.$num_fila)->applyFromArray($array_negro_header);
			
			$num_fila = 6;
			$columnas_tmp = InformacionMensualController::createColumnsArray('P');
			for($i=6; $i<sizeof($columnas_tmp); $i=$i+2)
			{
				$col1 = $columnas_tmp[$i];
				$col2 = $columnas_tmp[$i+1];
				
				$objPHPExcel->getActiveSheet()->mergeCells($col1.''.$num_fila.':'.$col2.''.$num_fila);
				$objPHPExcel->getActiveSheet()->setCellValue($col1.''.$num_fila, 'VENTAS');
				$objPHPExcel->getActiveSheet()->getStyle($col1.''.$num_fila)->applyFromArray($array_azul_claro_header);
			}

			$num_fila = 7;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$num_fila, 'Codigo');
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$num_fila, 'Descripcion');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$num_fila, 'Presentacion');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$num_fila, 'CodProv');
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$num_fila, 'NomProveed');
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$num_fila, 'Division');
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$num_fila)->applyFromArray($array_gris_header);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$num_fila)->applyFromArray($array_gris_header);
			
			$columnas_tmp = InformacionMensualController::createColumnsArray('P');
			for($i=6; $i<sizeof($columnas_tmp); $i=$i+2)
			{
				$col1 = $columnas_tmp[$i];
				$col2 = $columnas_tmp[$i+1];
				$objPHPExcel->getActiveSheet()->setCellValue($col1.''.$num_fila, 'UND');
				$objPHPExcel->getActiveSheet()->setCellValue($col2.''.$num_fila, 'PESOS');
				
				$objPHPExcel->getActiveSheet()->getStyle($col1.''.$num_fila)->applyFromArray($array_azul_claro_header);
				$objPHPExcel->getActiveSheet()->getStyle($col2.''.$num_fila)->applyFromArray($array_azul_claro_header);
			}
			
			if(sizeof($arr_ventas) > 0)
			{
				$num_fila = 8;
				foreach($arr_ventas as $ventas)
				{
					for($i=0; $i<sizeof($ventas); $i++)
					{
						if(isset($ventas[$i]) && $ventas[$i] != "" && isset($columnas[$i]))
						{
							$col = $columnas[$i];
							$objPHPExcel->getActiveSheet()->setCellValue($col.''.$num_fila, $ventas[$i]);
							$objPHPExcel->getActiveSheet()->getStyle($col.''.$num_fila)->applyFromArray($array_celda_izq);
						}
					}
					
					$num_fila++;
				}
			}
			
			if($interno == 1)
				$html .= '<span class="ocultar_proveedores"><br /><br /><b>Proveedor:</b> '.$nom_prov.'</span>';
				
			$html .= '<input type="hidden" id="cod_prov" name="cod_prov" value="'.md5($cod_prov).'" />
			<div id="cont-proveedores" class="ocultar_proveedores">
				<br />
				<div id="cont-exportar">
					<input type="button" id="export-data" class="btn btn-success" value="Exportar Inventarios y Ventas por Sucursal (en Excel)" /> &nbsp;&nbsp;&nbsp; 
					<input type="button" id="export-data-csv" class="btn btn-success" value="Exportar Inventarios y Ventas por PDV (en CSV)" /> 
				</div>
				<br />';
			
			if(sizeof($datos) >= $maximo)
				$html .= '<br /><div class="alert alert-info">Solo se muestran los primeros '.$maximo.' registros.</div><br />';
			
			$html .= '<table id="proveedores" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>SUC</th>
						<th>PDV</th>
						<th>NOMBRE PDV</th>
						<th>CIUDAD</th>
						<th>COD</th>
						<th>DESCRIPCION</th>
						<th>PRESENTACION</th>
						<th>PRV</th>
						<th>NOMPROVEEDOR</th>
						<th>Inv Und Total</th>
						<th>Vta Und Total</th>
					</tr>
				</thead>
				<tbody>';
			
			//Datos de la BD
			foreach($datos as $dat)
			{
				$html .= '<tr>
					<td>'.$dat["Sucursal"].'</td>
					<td>'.$dat["CodigoPDV"].'</td>
					<td>'.$dat["NombrePDV"].'</td>
					<td>'.$dat["NombreCiudad"].'</td>
					<td>'.$dat["CodigoProducto"].'</td>
					<td>'.$dat["NombreProducto"].'</td>
					<td>'.$dat["PresentacionProducto"].'</td>
					<td>'.$dat["CodigoProveedor"].'</td>
					<td>'.$dat["NombreProveedor"].'</td>
					<td>'.$dat["Inventario"].'</td>
					<td>'.$dat["Rotacion"].'</td>
				</tr>';
			}
			
			$html .= '</tbody>
				</table>
			</div>';
	
			//Se genera el archivo temporal
			for($i=0; $i<$num_paginas; $i++)
			{
				$objPHPExcel->setActiveSheetIndex($i);

				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
				
				\PHPExcel_Shared_Font::setAutoSizeMethod(\PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
				
				foreach($columnas as $col)
					$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
			}
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$dir = "/var/www/proveedores/tmp/csv/";
			$nom_arch = $dir.md5('data_'.time());
			$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save($nom_arch);
			
			$html .= '<input type="hidden" id="nom_arch" name="nom_arch" value="'.$nom_arch.'" />';	
			
			$searchModel = new \app\modules\proveedores\models\InformacionMensual();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
			return $this->render('informacion-mensual', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		}
		else
		{
			$html = "";
			$html = '<div class="ocultar_proveedores"><div class="alert alert-danger">Usuario bloqueado, No está autorizado para descargar esta información.</div></div>';			
			return $this->render('informacion-mensual', ['html' => $html]);
		}

	}
	else
	{
		$html = "";
		$html = '<div class="ocultar_proveedores"><div class="alert alert-danger">No hay datos para entregar en este momento!</div></div>';			
		return $this->render('informacion-mensual', ['html' => $html]);	
	}
	}
	
	
	public function createColumnsArray($end_column, $first_letters = '')
	{
	$columns = array();
	$length = strlen($end_column);
	$letters = range('A', 'Z');

	foreach($letters as $letter)
	{
		$column = $first_letters.$letter;
		$columns[] = $column;

		if($column == $end_column)
			return $columns;
	}

	foreach($columns as $column)
	{
		if(!in_array($end_column, $columns) && strlen($column) < $length)
		{
			$new_columns = InformacionMensualController::createColumnsArray($end_column, $column);
			$columns = array_merge($columns, $new_columns);
		}
	}

	return $columns;
	}
	
}