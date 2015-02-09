<?php 
$sql = "SELECT
					canal.nombre as Canal,
					count(DISTINCT wh_visita.id) as Reparaciones 
				FROM wh_visita
				LEFT JOIN canal ON wh_visita.canal = canal.id
				";
$sql .= " WHERE wh_visita.id > 0 \n";
$sql .= $filtros;
$sql .="  group by wh_visita.canal  ";
exportar_excel($sql);
echo "<h4>Cantidad Visitas por Canal</h4>";
echo '<div style=" height:400px; overflow:auto;">';
echo tabla_sql($sql);
echo "</div>";

?>