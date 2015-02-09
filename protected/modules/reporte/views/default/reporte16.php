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
					substring(fecha_visita,1,7) as Mes,
					SUM(wh_visita.cantidad_item*wh_visita.monto_item) as Monto 
				FROM wh_visita
				LEFT JOIN tipo_visita ON wh_visita.tipo_visita = tipo_visita.id
				";
$sql .= " WHERE wh_visita.id > 0 \n";
$sql .= $filtros;
$sql .=" group by wh_visita.tipo_visita,Mes
				ORDER BY Mes,wh_visita.tipo_visita
				";

$titulo = "Montos por Tipo Visita y Mes";
$tamano = array(800,480); // tamaño de la imagen en pixeles
$textoEjeX = "Año-Mes";
$textoEjeY = 'Monto ($)';

$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
exportar_excel($sql);

$num = mysqli_num_rows($result);

$data = array();
$leyendas = array();
$meses = array();
while($row = mysqli_fetch_assoc($result)){
	$matriz[utf8_encode($row["Tipo_Visita"])][$row["Mes"]] = $row["Monto"];
	$meses[$row["Mes"]] = $row["Mes"];
}

require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

$archivo = md5('r16'.json_encode($_GET)).".jpg"; // construyo un nombre de archivo basado en los filtros 

if(file_exists(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo) && (time() - filemtime(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo)) < 60*10 ){
	
}elseif (isset($matriz) && count($matriz)>0) {// el archivo no existe, lo creo
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$leyendas = array();
	
	foreach($matriz as $canal => $datos){
		foreach($meses as $mes){
			if(!in_array($mes,$leyendas)){
				$leyendas[] = $mes;
			}
			$data{$canal}[] = isset($matriz[$canal][$mes]) ? $matriz[$canal][$mes] : 0;
		}
	}
	if (count($data)>0) {
		
	// Create the graph. These two calls are always required
	$graph = new Graph($tamano[0],$tamano[1]);    
	$graph->SetScale("textlin");

	$graph->SetShadow();
	$graph->img->SetMargin(80,30,100,160);
	$graph->xaxis->SetTitleMargin(50);
	$graph->yaxis->SetTitleMargin(70);
	$graph->yaxis->scale->SetGrace(5);
	$graph->xaxis->SetLabelAngle(90);
	 
	// Create the bar plots
	foreach($matriz as $canal => $datos){
		$bplot{$canal} = new BarPlot($data{$canal});
		$bplot{$canal}->SetFillColor("orange");
		$bplot{$canal}->SetLegend(utf8_decode($canal));
		$bplot{$canal}->value->SetAngle(90); 
		$todas[] = $bplot{$canal};
	}
	
	$graph->xaxis->SetTickLabels($leyendas);
	
	// Adjust the legend position
	$graph->legend->Pos(0.2,0.1,'left','center');
		 
	// Create the grouped bar plot
	$gbplot = new GroupBarPlot($todas);
	 
	// ...and add it to the graPH
	$graph->Add($gbplot);
	foreach($matriz as $canal => $datos){
		$bplot{$canal}->value->Show();
		//$bplot{$canal}->SetValuePos('center');
		$bplot{$canal}->value->SetAngle(90);
		$bplot{$canal}->value->SetFormat('$%01.0f');
		$bplot{$canal}->value->HideZero();
 
	}
	 
	$graph->title->Set(utf8_decode($titulo));
	$graph->xaxis->title->Set(utf8_decode($textoEjeX));
	$graph->yaxis->title->Set(utf8_decode($textoEjeY));
	 
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	 
	$graph->Stroke(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);
	}
}
if (count($data)>0 && count($matriz)>0) {
	$src = Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);


?>
<img src="<?php echo $src ?>" />
<?php }
else{ ?>
<h4>No hay datos para mostrar con los filtros aplicados</h4>
<?php } ?>
