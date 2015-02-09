<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<style>
    input {
        max-width: 100%;
    } 
</style>
<body>
  <?php 
setlocale(LC_ALL, 'es_ES');


// New way
	$db_host = "localhost";
	$db_usuario = "cirigliano";
	$db_clave = "ciriglianodev";
	$db_base_de_datos = "cirigliano";
	//mysql_connect($db_host, $db_usuario, $db_clave); 
	//mysql_select_db($db_base_de_datos);
	$connection = mysqli_connect($db_host, $db_usuario, $db_clave, $db_base_de_datos);
	mysqli_set_charset ( $connection , "utf8" );

function exportar_excel($query){
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
	?><a href="excel?id=<?php echo $md5; ?>" target="_blank">Exportar a Excel</a><br /><?php 
}

function tabla_sql7($Query){
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
   
    $Result = mysqli_query($connection, $Query); //mysql_query($Query); //Execute the query
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
						$Table.= "<td>".$link."</td>";
					}
					if (is_numeric($value)) { //Registro Nuevo
						if ($Row['TipoVisita'] != 3) {
							# code...
							$id = (int)$value;
							$link = CHtml::link('R-'.$value,array('/historico/reparacion/view','id'=>$id));
							$Table.= "<td>".$link."</td>";
						}
						else{
							$id = (int)$value;
							$link = CHtml::link('T-'.$value,array('/historico/traslado/view','id'=>$id));
							$Table.= "<td>".$link."</td>";
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
?>
<?php 

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
function filtro_last_12_months(){
	$temp = "";
	$mes_actual = date('m');
	$ano_actual = date('Y');
	$mes_inicio = $mes_actual;
	$ano_inicio = $ano_actual-1;
	$fecha_inicio = $ano_inicio.'-'.$mes_inicio.'-01';
	$fecha_final = date('Y-m-d');
	$temp .= " AND fecha_creacion BETWEEN '".$fecha_inicio."' AND '".$fecha_final."' \n";	
	
	return $temp;
}

$filtros = "";
$filtros .= filtro_last_12_months();
$filtros .= filtro_sql("region","region");
$filtros .= filtro_sql("comuna","comuna");
$filtros .= filtro_sql("canal","canal");
$filtros .= filtro_sql("distribuidor","distribuidor");
$filtros .= filtro_texto_sql("direccion_punto","direccion_punto");
?>
<div class="container-fluid">

<div class="row">
	<div class="span12">
			<br />
			<?php
			if(isset($_GET['direccion_punto']) || isset($_GET['region']) || isset($_GET['comuna']) || isset($_GET['canal']) || isset($_GET['distribuidor']) ){
				include("reportePunto.php");
			}
			else{
				echo "<h2>Seleccione Dirección y Distribuidor para visualizar.</h2>";
			}
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
<form id="form1" name="form1" method="get" action="">
	<div class="span6">
		<div class="span6">
			<label for="direccion">Dirección</label>
		    <input type="text" name="direccion_punto" id="direccion_punto"  <?php echo isset($_GET['direccion_punto'])?'value="'.$_GET['direccion_punto'].'"':'' ?>/>
		    <label for="region">Región</label>
			<?php combo("region","region","id","nombre","orden");?>
			<label for="comuna">Comuna</label>
			<?php combo("comuna","comuna");?>
		
		</div>
		<div class="span6">
			<label for="distribuidor">Distribuidor</label>
			<?php combo("distribuidor","distribuidor");?>
			<label for="canal">Canal</label>
			<?php combo("canal","canal");?>
			<br />
			<br />
			<input class="btn btn-success" type="submit" value="Buscar" />
		</div>
	</div>

</form><br />
</div>

</div>
</div>

</body>
</html>