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
					descripcion_item as Elemento,
						sum(wh_visita.cantidad_item*wh_visita.monto_item) as Monto 
				FROM wh_visita
								";
$sql .= " WHERE wh_visita.id > 0 AND wh_visita.tipo_visita != 3 AND wh_visita.visita_preventiva != 1 AND wh_visita.descripcion_item != 'Mano de Obra' AND wh_visita.descripcion_item not like '%Preventiva%' AND wh_visita.descripcion_item NOT LIKE '%viatico%' AND wh_visita.descripcion_item NOT LIKE '%cambio%'\n";
$sql .= $filtros;
$sql .=" GROUP BY descripcion_item
                ORDER BY Monto DESC";
$sql .= " limit 10";


$titulo = "Montos por Elemento (TOP 10)";
$tamano = array(1000,600); // tamaño de la imagen en pixeles
$textoEjeX = "Elemento";
$textoEjeY = 'Monto ($)';

$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
exportar_excel($sql);

$num = mysqli_num_rows($result);

$data = array();
$leyendas = array();
while($row = mysqli_fetch_assoc($result)){
	$descr = trim(strip_tags($row["Elemento"]));
	if (strpos($descr, '/') !== FALSE){
		$foo = explode('/', $descr);
		if(count($foo) > 2)
			$descr = $foo[1];
	}
	$leyendas[] = strlen($descr)>35?mb_substr($descr,0,35,'UTF-8').'...':trim($descr);
	$data[] = $row["Monto"];
}
if (count($data)>0) {
		
	require_once ('jpgraph/jpgraph.php');
	require_once ('jpgraph/jpgraph_bar.php');

	$archivo = md5(json_encode($_GET)).".jpg"; // construyo un nombre de archivo basado en los filtros 

	if(file_exists(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo) && (time() - filemtime(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo)) < 60*10 ){
		
	}else{// el archivo no existe, lo creo
		
		$graph = new Graph($tamano[0],$tamano[1],'auto');
		$graph->SetScale("textlin");
		$graph->img->SetMargin(150,30,100,260);
		$graph->yaxis->SetTitleMargin(70);
		$graph->xaxis->SetTitleMargin(70);
		$graph->yaxis->scale->SetGrace(5);
		// Create a bar pot
		$bplot = new BarPlot($data);
		$graph->Add($bplot);
		$bplot->value->Show();
		$bplot->value->SetFormat('$%01.0f');
		$bplot->value->SetAngle(90); 
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->title->Set(utf8_decode($titulo));
		$graph->xaxis->title->Set(utf8_decode($textoEjeX));
		$graph->yaxis->title->Set(utf8_decode($textoEjeY));
		$graph->xaxis->SetTickLabels($leyendas);
		$graph->xaxis->SetLabelAngle(45);
		$graph->xaxis->SetLabelMargin(3); 
		//$graph->xaxis->SetLabelAlign('center','center');
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		//$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD, 5);

		$graph->Stroke(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);
	}

	$src = Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);

	?>
	<img src="<?php echo $src ?>" />
	<?php }
	else{ ?>
	<h4>No hay datos para mostrar con los filtros aplicados</h4>
	<?php } ?>

