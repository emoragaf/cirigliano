<?php
$db_host = "localhost";
$db_usuario = "cirigliano";
$db_clave = "ciriglianodev";
$db_base_de_datos = "cirigliano";
//mysql_connect($db_host, $db_usuario, $db_clave); 
//mysql_select_db($db_base_de_datos);
$connection = mysqli_connect($db_host, $db_usuario, $db_clave, $db_base_de_datos); 
mysqli_set_charset ( $connection , "utf8" );
 
$sql = "SELECT 
					IF(day(fecha_creacion)>=25,DATE_FORMAT(DATE_ADD(fecha_creacion, INTERVAL 1 MONTH),'%Y-%m'),DATE_FORMAT(fecha_creacion, '%Y-%m')) as Periodo,
					count(DISTINCT wh_visita.id) as Reparaciones 
				FROM wh_visita
				";
$sql .= " WHERE wh_visita.id > 0 \n";
$sql .= $filtros;
$sql .=" group by Periodo \n order by year(fecha_visita) ASC, month(fecha_visita) ASC";


$titulo = "Cantidad Visitas por Mes";
$tamano = array(640,480); // tamaño de la imagen en pixeles
$textoEjeX = "Año-Mes";
$textoEjeY = "Reparaciones";

$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
exportar_excel($sql);

$num = mysqli_num_rows($result);

$data = array();
$leyendas = array();
while($row = mysqli_fetch_assoc($result)){
	$leyendas[] = utf8_encode($row["Periodo"]);
	$data[] = $row["Reparaciones"];
}
if (count($data)>0) {
	
	require_once ('jpgraph/jpgraph.php');
	require_once ('jpgraph/jpgraph_bar.php');

	$archivo = md5(json_encode($_GET)).".jpg"; // construyo un nombre de archivo basado en los filtros 

	if(file_exists(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo) && (time() - filemtime(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo)) < 60*10 ){
		
	}else{// el archivo no existe, lo creo
		
		$graph = new Graph($tamano[0],$tamano[1],'auto');
		$graph->SetScale("textlin");
		$graph->img->SetMargin(60,30,100,120);
		$graph->yaxis->SetTitleMargin(45);
		$graph->xaxis->SetTitleMargin(45);
		$graph->yaxis->scale->SetGrace(5);
		// Create a bar pot
		$bplot = new BarPlot($data);
		$graph->Add($bplot);
		$bplot->value->Show();
		$bplot->value->SetAngle(90);
		$bplot->value->SetFormat('%01.0f'); 
		$graph->title->Set(utf8_decode($titulo));
		$graph->xaxis->title->Set(utf8_decode($textoEjeX));
		$graph->yaxis->title->Set(utf8_decode($textoEjeY));
		$graph->xaxis->SetTickLabels($leyendas);
		$graph->xaxis->SetLabelAngle(40);
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->Stroke(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);
	}

	$src = Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);
	?>
	<img src="<?php echo $src?>" />
<?php 
}
else{ ?>
<h4>No hay datos para mostrar con los filtros aplicados.</h4>
<?php } ?>
