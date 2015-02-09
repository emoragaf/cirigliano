<?php 
$sql = "SELECT
					wh_visita.descripcion_item as Elemento,
					count(DISTINCT wh_visita.id) as Reparaciones 
				FROM wh_visita
				";
$sql .= " WHERE wh_visita.id > 0 AND wh_visita.tipo_visita != 3 AND wh_visita.visita_preventiva != 1 AND wh_visita.descripcion_item != 'Mano de Obra' AND wh_visita.descripcion_item not like '%Preventiva%' AND wh_visita.descripcion_item NOT LIKE '%viatico%' AND wh_visita.descripcion_item NOT LIKE '%cambio%'\n";

//$sql .= " AND wh_visita.tipo_visita != 3 \n";
$sql .= $filtros;
$sql .="  group by wh_visita.descripcion_item  ";
echo '<div class="row well"';
exportar_excel($sql);
echo "<h4>Cantidad Elementos Reparados</h4>";

echo '<div style=" height:300px; overflow:auto;">';
echo tabla_sql($sql);
echo "</div>";

echo "</div>";

?>