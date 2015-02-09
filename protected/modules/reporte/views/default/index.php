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
function tabla_sql($Query){
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
            foreach($Row as $field => $value)
            {
				$value = $value;
				if(is_numeric($value)){
					$Table.= '<td style="text-align:right;">'.$value.'</td>';
				}
				else
                	$Table.= "<td>$value</td>";
            }
            $Table.= "</tr>";
        }
        //$Table.= "<tr><td colspan='$NumFields'><strong>La consulta entreg&oacute; " . mysql_num_rows($Result) . " filas.</strong> </td></tr>";
    }
    $Table.= "</table>";
   
    return $Table;
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
function tabla_sql3($Query){
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
            	
            	elseif($field != 'TipoVisita'){
					$value = $value;
	                if(is_numeric($value)){
					$Table.= '<td style="text-align:right;">'.$value.'</td>';
				}
				else
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
?>
<div class="container-fluid">

<div class="row">
	<div class="span12">
			<br />
			<?php
			if(isset($_GET['reporte']) && !empty($_GET['reporte'])){
				include("reporte".$_GET['reporte'].".php");
			}
			else{
				echo "<h2>Seleccione Reporte y Filtros para visualizar.</h2>";
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
<h3>Filtros </h3>
<form id="form1" name="form1" method="get" action="">
	<div class="span4">
		<label for="reporte"><b>Reporte</b></label>
		<select name="reporte" id="reporte">
  			<option value="">Seleccionar</option>
  			
  			<option value="3" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==3?'selected="selected"':'' ?>>Elementos Reparados</option>
  			<option value="22" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==22?'selected="selected"':'' ?>>Visitas por Canal</option>
  			<option value="6" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==6?'selected="selected"':'' ?>>Cantidad Elementos Reparados</option>
  			<option value="23" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==23?'selected="selected"':'' ?>>Cantidad Visitas por Mes</option>
  			<option value="24" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==24?'selected="selected"':'' ?>>Montos por Canal y Mes</option>
  			<option value="25" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==25?'selected="selected"':'' ?>>Montos por Canal y Región</option>
  			<option value="26" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==26?'selected="selected"':'' ?>>Montos por Elemento (TOP 10)</option>
  			 <option value="18" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==18?'selected="selected"':'' ?>>Por Tipo Visita (Cantidad) </option>
  			<option value="19" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==19?'selected="selected"':'' ?>>Por Region </option>
  			<option value="20" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==20?'selected="selected"':'' ?>>Por Tipo Visita ($) </option>
  			<option value="21" <?php echo isset($_GET['reporte'])&&$_GET['reporte']==21?'selected="selected"':'' ?>>Montos por Mes </option>

  		</select>

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
		<?php combo("distribuidor","distribuidor");?>

		<label for="canal">Canal</label>
		<?php combo("canal","canal");?>

		<label for="mueble">Mueble</label>
		<?php combo("mueble","mueble","id","descripcion");?>
		<br />
		<input class="btn btn-success" type="submit" value="Filtrar" />
	</div>

</form><br />
</div>

</div>
</div>

</body>
</html>