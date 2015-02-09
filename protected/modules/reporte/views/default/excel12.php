<?php
$db_host = "localhost";
$db_usuario = "cirigliano";
$db_clave = "ciriglianodev";
$db_base_de_datos = "cirigliano";
$connection = mysqli_connect($db_host, $db_usuario, $db_clave, $db_base_de_datos);
mysqli_set_charset ( $connection , "utf8" );

function filtro_sql($campo_sql,$campo_get){
	$temp = "";
	if(isset($_GET[$campo_get]) && !empty($_GET[$campo_get])){
		if(is_array($_GET[$campo_get])){
			if(count($_GET[$campo_get])>0 && !empty(implode("",$_GET[$campo_get]))){
				$temp .= " AND ".$campo_sql." = '".implode("' OR ".$campo_sql." = '",$_GET[$campo_get])."' \n";
			}
		}else{
			$temp .= " AND ".$campo_sql." = '".$_GET[$campo_get]."' \n";
		}
	}
	return $temp;
}
function filtro_texto_sql($campo_sql,$campo_get){
	$temp = "";
	if(isset($_GET[$campo_get]) && !empty($_GET[$campo_get])){
		$temp .= " AND ".$campo_sql." like '%".$_GET[$campo_get]."%' \n";
	}
	return $temp;
}

$filtros = "";
$filtros .= filtro_sql("year(`fecha_visita`)","ano");
$filtros .= filtro_sql("month(`fecha_visita`)","mes");
$filtros .= filtro_sql("tipo_visita","tipo_visita");
$filtros .= filtro_sql("region","region");
$filtros .= filtro_sql("comuna","comuna");
$filtros .= filtro_sql("canal","canal");
$filtros .= filtro_sql("distribuidor","distribuidor");
$filtros .= filtro_sql("mueble","mueble");
$filtros .= filtro_texto_sql("folio","folio");
$filtros .= filtro_texto_sql("direccion_punto","direccion_punto");

$sql = "SELECT 
					region.nombre as Region,
					Year(wh_visita.fecha_visita) as Ano,
					month(wh_visita.fecha_visita) as Mes,
						sum(wh_visita.cantidad_item*wh_visita.monto_item) as Monto 
				FROM wh_visita
				LEFT JOIN region ON wh_visita.region = region.id
				";
$sql .= " WHERE wh_visita.id > 0 \n";
$sql .= $filtros;
$sql .="  group by region.orden,Ano, Mes ";

$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$num = mysqli_num_rows($result);

$columnas = array();

if($num>0){
	while($row = mysqli_fetch_assoc($result)){
		$region = utf8_encode($row["Region"]);
		$mes = $row["Mes"];
			$mes = (strlen($mes)<2) ? "0".$mes : $mes;
		$ano = $row["Ano"];
		$monto = $row["Monto"];
		$matriz[$region][$ano."-".$mes] = $monto;
		$columnas[$ano."-".$mes] = $ano."-".$mes;
	}
	sort($columnas);

	/** Error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');
	
	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');
	
	/** Include PHPExcel */
	//require_once dirname(__FILE__) . '/PHPExcel/PHPExcel.php';
	
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set document properties
	$objPHPExcel->getProperties()->setCreator("ExeFire")
								 ->setLastModifiedBy("Cirigliano")
								 ->setTitle("")
								 ->setSubject("")
								 ->setDescription("")
								 ->setKeywords("")
								 ->setCategory("");
	
	// Escribe Encabezados
	$i=1;
	foreach($columnas as $col){
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, $col);
		$i++;
	}
	
	// Carga Datos
	$fila = 2;
	foreach($matriz as $region => $anos){
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $fila, $region);
		$colu=1;
		foreach($columnas as $col){
			$value = isset($matriz[$region][$col]) ? $matriz[$region][$col] : 0;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colu, $fila, $value);
			$colu++;
		}	
		$fila++;
	}
	
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
	
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.trim("reporte12").'.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
}else{
	echo "Error: Los filtros que ha seleccionado no encuentran datos para exportar.";
}

?>

