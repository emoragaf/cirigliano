<?php
setlocale(LC_ALL, 'es_ES');
function exportar_excelDist($query){
	$db_host = "localhost";
	$db_usuario = "cirigliano";
	$db_clave = "ciriglianodev";
	$db_base_de_datos = "cirigliano";
	//mysql_connect($db_host, $db_usuario, $db_clave); 
	//mysql_select_db($db_base_de_datos);
	$connection = mysqli_connect($db_host, $db_usuario, $db_clave, $db_base_de_datos); 
	$md5 = md5($query);
	$sql = "INSERT INTO wh_visita_query VALUES ('".trim($md5)."','".str_replace("'","''",$query)."');";
	mysqli_query($connection, $sql) or mysqli_error($connection);
	?><a href="excelDist?id=<?php echo $md5; ?>" class="btn btn-success" target="_blank">Exportar a Excel</a><br /><?php 
}
function tabla_sql7($query){
	$db_host = "localhost";
	$db_usuario = "cirigliano";
	$db_clave = "ciriglianodev";
	$db_base_de_datos = "cirigliano";
	//mysql_connect($db_host, $db_usuario, $db_clave); 
	//mysql_select_db($db_base_de_datos);
	$connection = mysqli_connect($db_host, $db_usuario, $db_clave, $db_base_de_datos); 
	mysqli_set_charset ( $connection , "utf8" );

    $Table = "";  //initialize table variable
   
    $Table.= "<br><table class='table' border='1'>"; //Open HTML Table
   
    $Result = mysqli_query($connection, $query); //mysql_query($Query); //Execute the query
    if(mysqli_error($connection))
    {
        $Table.= "<tr><td>MySQL ERROR: " . mysqli_error($connection) . "</td></tr>";
    }
    else
    {
        //Header Row with Field Names
        $NumFields = mysqli_num_fields($Result);
        $Table.= "<tr>";
        for ($i=0; $i < $NumFields; $i++)
        {  

        	$property = mysqli_fetch_field($Result);
        	if($property->name != 'TipoVisita')
            	$Table.= "<th>" . str_replace("_"," ", $property->name). "</th>";
        }
        $Table.= "</tr>";
   
        //Loop thru results
        $RowCt = 0; //Row Counter
        while($Row = mysqli_fetch_assoc($Result))
        {
            //Alternate colors for rows
            //if($RowCt++ % 2 == 0) $Style = "background-color: #EFEFEF;";
            //else $Style = "background-color: #FFFFFF;";
           
            $Table.= "<tr>";
            //Loop thru each field
            $i = 0;
            foreach($Row as $field => $value)
            {
            	$i++;
            	if($i == 1){
            		//verificar si es registro histórico o nuevo
            		if (!is_numeric($value)) { //Registro Nuevo
            			$id = $value;
						$id = str_replace('T', '', $id);
						$id = str_replace('R', '', $id);
						$id = (int)$id;
						$link = CHtml::link($value,array('/visita/view','id'=>$id));
						$Table.= '<td style="min-width:50px">'.$link.'</td>';
					}
					if (is_numeric($value)) { //Registro Nuevo
						if ($Row['TipoVisita'] != 3) {
							# code...
							$id = (int)$value;
							$link = CHtml::link('R-'.$value,array('/historico/reparacion/view','id'=>$id));
							$Table.= '<td style="min-width:50px">'.$link.'</td>';
						}
						else{
							$id = (int)$value;
							$link = CHtml::link('T-'.$value,array('/historico/traslado/view','id'=>$id));
							$Table.= '<td style="min-width:50px">'.$link.'</td>';
						}
					}
            	}
            	elseif($i == 8){
            		$value = $value;
	                $Table.= '<td style="text-align:right">'.$value.'</td>';
            	}
            	elseif($field != 'TipoVisita' && $i!= 8){
					$value = $value;
	                $Table.= "<td>$value</td>";
            	}
            }
            $Table.= "</tr>";
        }
        //$Table.= "<tr><td colspan='$NumFields'><strong>La consulta entreg&oacute; " . mysql_num_rows($Result) . " filas.</strong> </td></tr>";
    }
    $Table.= "</table>";
   
    return $Table;
}
function combo($campo,$maestro,$id="id",$nombre="nombre",$orden="",$size=1){
	$db_host = "localhost";
$db_usuario = "cirigliano";
$db_clave = "ciriglianodev";
$db_base_de_datos = "cirigliano";
//mysql_connect($db_host, $db_usuario, $db_clave); 
//mysql_select_db($db_base_de_datos);
$connection = mysqli_connect($db_host, $db_usuario, $db_clave, $db_base_de_datos); 
mysqli_set_charset ( $connection , "utf8" );

	$sql = "SELECT * FROM `".$maestro."` ";
	if(!empty($orden)){
		$sql .= "ORDER BY `".$orden."` ASC  ";
	}else{
		$sql .= "ORDER BY `".$nombre."` ASC  ";
	}
	$result = mysqli_query($connection,$sql);
	$num = mysqli_num_rows($result);
	?>
  <select name="<?php echo $campo; ?><?php if($size>1){echo "[]";}?>"  id="<?php echo $campo; ?><?php if($size>1){echo "[]";}?>" <?php if($size>1){?> size="<?php echo $size; ?>" multiple="MULTIPLE"<?php }?> >
    <option value="" <?php if(!isset($_GET[$campo]) || isset($_GET[$campo]) && empty($_GET[$campo])){?> selected="selected" <?php }?>>Seleccionar</option>
  	<?php 
  		
  		 while($row = mysqli_fetch_assoc($result)) {
  			//echo $row;
  			$key = $row[$id];
			$value = $row[$nombre];
			$seleccionado = false;
			if(isset($_GET[$campo]) && $_GET[$campo]==$key || isset($_GET[$campo]) && is_array($_GET[$campo]) && in_array($key,$_GET[$campo])){
				$seleccionado = true;
			}
	?>
    <option value="<?php echo $key; ?>" <?php if($seleccionado){?> selected="selected" <?php }?>><?php echo $value; ?></option>
    <?php }?>
  </select>
	<?php
}
function filtro_sql($campo_sql,$campo_get){
	$temp = "";
	if(isset($_GET[$campo_get]) && !empty($_GET[$campo_get])){
		if(is_array($_GET[$campo_get])){
			if(count($_GET[$campo_get])>0 && !empty(implode("",$_GET[$campo_get]))){
				$temp .= " AND ".$campo_sql." in (".implode(",",$_GET[$campo_get]).") \n";
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
function filtro_fecha_sql(){
	$temp = "";
	if (isset($_GET['ano']) && !empty($_GET['ano']) && empty($_GET['mes'])) {
			$temp .= " AND year(`fecha_creacion`) = ".$_GET['ano']." \n";
	}
	if (isset($_GET['mes']) && !empty($_GET['mes']) && empty($_GET['ano'])) {
			$temp .= " AND month(`fecha_creacion`) = ".$_GET['mes']." \n";
	}
	if (isset($_GET['mes']) && !empty($_GET['mes']) && isset($_GET['ano']) && !empty($_GET['ano']) ) {
			$mes_inicio = $_GET['mes']-1>0?$_GET['mes']-1:12;
			$ano_inicio = $_GET['mes']-1>0?$_GET['ano']:$_GET['ano']-1;
			$fecha_inicio = $ano_inicio.'-'.$mes_inicio.'-25';
			$fecha_final = $_GET['ano'].'-'.$_GET['mes'].'-24';
			$temp .= " AND fecha_creacion BETWEEN '".$fecha_inicio."' AND '".$fecha_final."' \n";	
	}
	return $temp;
}

$filtros = "";
$filtros .= filtro_fecha_sql();
$filtros .= filtro_sql("tipo_visita","tipo_visita");
$filtros .= filtro_sql("region","region");
$filtros .= filtro_sql("comuna","comuna");
$filtros .= filtro_sql("canal","canal");
$filtros .= filtro_sql("distribuidor","distribuidor");
$filtros .= filtro_sql("mueble","mueble");
$filtros .= filtro_texto_sql("folio","folio");
$filtros .= filtro_texto_sql("direccion_punto","direccion_punto");
$filtros .= filtro_sql("visita_preventiva","visita_preventiva");
$sql = "SELECT
					wh_visita.folio as Folio,
					wh_visita.tipo_visita as TipoVisita,
					wh_visita.direccion_punto as Direccion, 
					comuna.nombre as Comuna,
					canal.nombre as Canal,
					distribuidor.nombre as Distribuidor,
					wh_visita.fecha_creacion as Fecha_Creacion,
					wh_visita.fecha_visita as Fecha_Visita,
					sum(wh_visita.cantidad_item*wh_visita.monto_item) as Monto 
				FROM wh_visita
				LEFT JOIN	comuna ON wh_visita.comuna = comuna.id
				LEFT JOIN	distribuidor ON wh_visita.distribuidor = distribuidor.id
				LEFT JOIN	canal ON wh_visita.canal = canal.id
				";
$sql .= " WHERE wh_visita.id > 0 \n";
$sql .= $filtros;
//$sql .= " AND wh_visita.tipo_visita != 3 \n";
$sql .="  group by folio, tipo_visita  ";
$sql .=" order by distribuidor, fecha_creacion DESC";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Visitas Por Distribuidor</title>
</head>
<style>
    input {
        max-width: 100%;
    } 
</style>
<body>
<div class="container-fluid">
<div class="row">
	<div class="span12">
		<h1>Lista agrupada por Distribuidor</h1>
		<div class="well">
			<?php
			exportar_excelDist($sql);
			?>
			<div style=" height:300px; overflow:auto;">
			<?php echo tabla_sql7($sql); ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="span12">
			<?php
			if(false){// debug
			?>
			<h3>debug</h3>
			<hr />
			<?php
			if(isset($sql)){
				echo nl2br($sql);
			}
			?>
			<hr />
			<pre><?php print_r($_GET);?></pre>
			<?php }?>
	</div>
</div>
<div class="row well">
<h3>Filtros </h3>
<form id="form1" name="form1" method="get" action="">
	<div class="span4">

  		<label for="folio">Folio</label>
  		<input type="text" name="folio" id="folio"  />

  		<label for="ano">Año</label>
  		<select name="ano" id="ano">
		    <option value="" <?php if(!isset($_GET["ano"]) || isset($_GET["ano"]) && empty($_GET["ano"])){?> selected="selected" <?php }?>>Seleccionar</option>
		      <?php for($i=2012;$i<=date("Y");$i++){
						?>
	      <option value="<?php echo $i; ?>" <?php if(isset($_GET['ano']) && $_GET['ano']==$i){?> selected="selected" <?php }?>><?php echo $i; ?></option>
	      <?php }?>
      	</select>

      	<label for="mes">Mes</label>
      	<select name="mes" id="mes">
		    <option value="" <?php if(!isset($_GET["mes"]) || isset($_GET["mes"]) && empty($_GET["mes"])){?> selected="selected" <?php }?>>Seleccionar</option>
		      <?php for($i=1;$i<=12;$i++){
		      			$nombre_mes = ucfirst(strftime('%B',mktime(0,0,0,$i,1,2014)));
						//$nombre_mes = date("M",mktime(0,0,0,$i,1,2014)); // CAMBIAR POR NOMBRES EN ESPAÑO
						?>
		      <option value="<?php echo $i; ?>" <?php if(isset($_GET['mes']) && $_GET['mes']==$i){?> selected="selected" <?php }?>><?php echo $nombre_mes; ?></option>
		      <?php }?>
	    </select>
	    <label for="mueble">Mueble</label>
		<?php combo("mueble","mueble","id","descripcion");?>

	</div>
	<div class="span4">
		<label for="tipo_visita">Tipo Visita</label>
		<?php combo("tipo_visita","tipo_visita","id","nombre","nombre",5);?>

		<?php echo TbHtml::checkBox('visita_preventiva', isset($_GET['visita_preventiva'])?true:false , array('label' => 'Visita Preventiva','value'=>'1')); ?>



		<label for="region">Región</label>
		<?php combo("region","region","id","nombre","orden");?>

		<label for="comuna">Comuna</label>
		<?php combo("comuna","comuna");?>

		

	</div>
	<div class="span4">
		<label for="direccion">Dirección</label>
	    <input type="text" name="direccion_punto" id="direccion_punto"  <?php echo isset($_GET['direccion_punto'])?'value="'.$_GET['direccion_punto'].'"':'' ?>/>

		<label for="distribuidor">Distribuidor</label>
		<?php combo("distribuidor","distribuidor","id","nombre","",5);?>

		<label for="canal">Canal</label>
		<?php combo("canal","canal");?>

		
		<br />
		<input class="btn btn-success" type="submit" value="Filtrar" />
	</div>

</form><br />
</div>

</div>
</div>

</body>
</html>