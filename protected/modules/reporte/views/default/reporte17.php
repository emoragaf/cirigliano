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
					tipo_visita.nombre as Tipo_Visita,
					sum(wh_visita.cantidad_item*wh_visita.monto_item) as Monto 
				FROM wh_visita
				LEFT JOIN tipo_visita ON wh_visita.tipo_visita = tipo_visita.id
				";
$sql .= " WHERE wh_visita.id > 0 \n";
$sql .= $filtros;
$sql .=" group by wh_visita.tipo_visita ";


$titulo = "Porcentaje Tipo Visita por Montos";
$tamano = array(640,480); // tamaño de la imagen en pixeles

// Some data

$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
exportar_excel($sql);

$num = mysqli_num_rows($result);

$data = array();
$leyendas = array();
while($row = mysqli_fetch_assoc($result)){
	$leyendas[] = utf8_encode($row["Tipo_Visita"]);
	$data[] = $row["Monto"];
}
if (count($data)>0) {
		
	require_once ('jpgraph/jpgraph.php');
	require_once ('jpgraph/jpgraph_pie.php');

	$archivo = md5('r17'.json_encode($_GET)).".jpg"; // construyo un nombre de archivo basado en los filtros 

	if(file_exists(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo) && (time() - filemtime(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo)) < 60*10 ){
		
	}else{// el archivo no existe, lo creo
		$graph = new PieGraph($tamano[0],$tamano[1],'auto');
		$graph->SetShadow();
		$graph->title->Set(utf8_decode($titulo));
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$p1 = new PiePlot($data);
		$p1->SetLegends($leyendas);	
		$graph->Add($p1);
		$graph->Stroke(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);
	}
	$src = Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);

	?>
	<img src="<?php echo $src ?>" />
	<?php }
	else{ ?>
	<h4>No hay datos para mostrar con los filtros aplicados</h4>
	<?php } ?>


