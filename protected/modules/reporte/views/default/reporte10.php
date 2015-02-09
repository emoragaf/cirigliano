<?php 
$db_host = "localhost";
$db_usuario = "cirigliano";
$db_clave = "ciriglianodev";
$db_base_de_datos = "cirigliano";
//mysql_connect($db_host, $db_usuario, $db_clave); 
//mysql_select_db($db_base_de_datos);
if (isset($_GET['ano']) && !empty($_GET['ano'])) {
$connection = mysqli_connect($db_host, $db_usuario, $db_clave, $db_base_de_datos); 
mysqli_set_charset ( $connection , "utf8" );

$sql = "SELECT
					canal.nombre as Canal,
					region.nombre as Region,
					SUM(wh_visita.cantidad_item*wh_visita.monto_item) as Monto 
				FROM wh_visita
				LEFT JOIN canal ON wh_visita.canal = canal.id
				LEFT JOIN region ON wh_visita.region = region.id
				";
$sql .= " WHERE wh_visita.id > 0 \n";
$sql .= $filtros;
$sql .=" group by wh_visita.canal,Region
				ORDER BY Region,Canal
				";

$titulo = "Montos por Canal y Región";
$tamano = array(1000,720); // tamaño de la imagen en pixeles
$textoEjeX = "Región";
$textoEjeY = 'Monto ($)';

$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
exportar_excel($sql);

$num = mysqli_num_rows($result);

$data = array();
$leyendas = array();
$meses = array();
while($row = mysqli_fetch_assoc($result)){
	$matriz[utf8_encode($row["Canal"])][$row["Region"]] = $row["Monto"];
	$meses[$row["Region"]] = $row["Region"];
}
if (isset($matriz) && count($matriz)>0) {
		
	require_once ('jpgraph/jpgraph.php');
	require_once ('jpgraph/jpgraph_bar.php');

	$archivo = md5(json_encode($_GET)).".jpg"; // construyo un nombre de archivo basado en los filtros 

	if( file_exists(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo) && (time() - filemtime(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo)) < 60*10 ){
		
	}else{// el archivo no existe, lo creo
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

		// Create the graph. These two calls are always required
		$graph = new Graph($tamano[0],$tamano[1]);    
		$graph->SetScale("textlin");
		 
		$graph->SetShadow();
		$graph->img->SetMargin(90,30,100,160);
		$graph->xaxis->SetTitleMargin(80);
		$graph->yaxis->SetTitleMargin(70);
		$graph->yaxis->scale->SetGrace(5);
		$graph->xaxis->SetLabelAngle(90);
		 
		// Create the bar plots
		foreach($matriz as $canal => $datos){
			$bplot{$canal} = new BarPlot($data{$canal});
			$bplot{$canal}->SetFillColor("orange");
			//$bplot{$canal}->Setwidth(20);
			$bplot{$canal}->SetLegend(utf8_decode($canal));
			//$bplot{$canal}->value->SetAlign('center');
			

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
			$bplot{$canal}->value->SetFormat('$%01.0f');
			$bplot{$canal}->value->SetAngle(90);
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
	$src = Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot').'/protected/modules/reporte/views/default/images/'.$archivo);


	?>
	<img src="<?php echo $src ?>" />
	<?php }
	else{ ?>
	<h4>No hay datos para mostrar con los filtros aplicados</h4>
	<?php }
	}
	else{
		echo "<h4>Seleccione año para mostrar gráfico.</h4>";
		} ?>

