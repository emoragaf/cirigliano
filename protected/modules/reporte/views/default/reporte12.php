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

$result = mysqli_query($connection,$sql) or die(mysql_error($connection));
echo '<a href="excel2?id='.http_build_query($_GET).'" target="_blank">Exportar a Excel</a>';

$num = mysqli_num_rows($result);

$columnas = array();
while($row = mysqli_fetch_assoc($result)){
	$region = $row["Region"];
	$mes = $row["Mes"];
		$mes = (strlen($mes)<2) ? "0".$mes : $mes;
	$ano = $row["Ano"];
	$monto = $row["Monto"];
	$matriz[$region][$ano."-".$mes] = $monto;
	$columnas[$ano."-".$mes] = $ano."-".$mes;
}
sort($columnas);
/*
for($i=0;$i<=$num;$i++){
	$region = utf8_encode(mysql_result($result,$i,"Region"));
	$mes = mysql_result($result,$i,"Mes");
		$mes = (strlen($mes)<2) ? "0".$mes : $mes;
	$ano = mysql_result($result,$i,"Ano");
	$monto = mysql_result($result,$i,"Monto");
	$matriz[$region][$ano."-".$mes] = $monto;
	$columnas[$ano."-".$mes] = $ano."-".$mes;
}*/
?>
<STYLE TYPE="text/css">
td{font-family: Arial; font-size: 11px;}
</STYLE>
<?php if (isset($matriz) && count($matriz)>0): ?>
	
<h4>Tabla montos por Region y Mes</h4>
<table border="1">
  <tr>
    <td>&nbsp;</td>
    <?php	foreach($columnas as $col){?>
    <td><?php echo $col; ?></td>
    <?php	}	?>
  </tr>
  <?php foreach($matriz as $region => $anos){?>
  <tr>
    <td style="text-align:right"><?php echo $region; ?></td>
    <?php foreach($columnas as $col){?>
    <td style="text-align:right"><?php echo isset($matriz[$region][$col]) ? $matriz[$region][$col] : 0; ?></td>
    <?php	}	?>
  </tr>
  <?php }?>
</table>
<?php else: ?>
	<h4>No hay datos para mostrar con los filtros aplicados.</h4>
<?php endif ?>
