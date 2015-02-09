<?php 
$sql = "SELECT tipo_visita.nombre as Tipo_Visita,count(DISTINCT wh_visita.id) as Reparaciones FROM wh_visita
				LEFT JOIN tipo_visita ON wh_visita.tipo_visita = tipo_visita.id
				";
$sql .= " WHERE wh_visita.id > 0 \n";
$sql .= $filtros;
$sql .=" group by wh_visita.tipo_visita ";
exportar_excel($sql);
echo "<h4>Tipo Visita (Cantidad)</h4>";
echo tabla_sql($sql);

?>