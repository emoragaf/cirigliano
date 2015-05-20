<?php 
if(isset($_GET['id'])){
	$db_host = "localhost";
	$db_usuario = "cirigliano";
	$db_clave = "ciriglianodev";
	$db_base_de_datos = "cirigliano";
	$connection = mysqli_connect($db_host, $db_usuario, $db_clave, $db_base_de_datos);
	mysqli_set_charset ( $connection , "utf8" );

	$sql = "SELECT * FROM `wh_visita_query` WHERE `md5` = '".trim($_GET['id'])."' ";
	$result = mysqli_query($connection, $sql);
	$num = mysqli_num_rows($result);
	if($num>0){
		while($row = mysqli_fetch_assoc($result)){
			$query = $row["query"];
		}
		//echo nl2br($query)."<br><br>";
		$result = mysqli_query($connection, $query);
		$num = mysqli_num_rows($result);
		if($num>0){
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
			$NumFields = mysqli_num_fields($result);
			for ($i=0; $i < $NumFields; $i++){    
				$property = mysqli_fetch_field($result);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, str_replace("_"," ", $property->name));
			}
			
			// Carga Datos
			$fila = 2;
			$lastRow = null;
			while($Row = mysqli_fetch_assoc($result)){
				if($lastRow && (isset($lastRow['Distribuidor']) && isset($Row['Distribuidor'])&& strcasecmp($lastRow['Distribuidor'],$Row['Distribuidor']) !== 0 ) || (!isset($lastRow['Distribuidor']) && isset($Row['Distribuidor'])) ){
					$fila++;
				}
				$col = 0;
				foreach($Row as $field => $value){
					$value = utf8_encode($value);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $fila, utf8_decode($value));
					$col++;
				}
				$fila++;
				$lastRow = $Row;
			}
			
			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
			
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			
			
			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.trim($_GET['id']).'.xlsx"');
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
	}else{
		echo "Error: No se encuentra query para ese ID.";
	}
}else{
	echo "Error: No viene ID;";
}
?>