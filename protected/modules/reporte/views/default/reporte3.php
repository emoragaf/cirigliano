<?php 
$sql = "SELECT 
					wh_visita.folio as Folio,
					wh_visita.descripcion_item as Elemento,
					wh_visita.tipo_visita as TipoVisita,
					sum(wh_visita.cantidad_item) as Cantidad,
					sum(wh_visita.cantidad_item*wh_visita.monto_item) as Monto 
				FROM wh_visita
				";
$sql .= " WHERE wh_visita.id > 0 AND wh_visita.tipo_visita != 3 AND wh_visita.visita_preventiva != 1 AND wh_visita.descripcion_item != 'Mano de Obra' AND wh_visita.descripcion_item not like '%Preventiva%' AND wh_visita.descripcion_item NOT LIKE '%viatico%' AND wh_visita.descripcion_item NOT LIKE '%cambio%'\n";

//$sql .= " AND wh_visita.tipo_visita != 3 \n";
$sql .= $filtros;
$sql .=" group by wh_visita.descripcion_item, wh_visita.folio ORDER BY fecha_creacion DESC, folio";
echo "<div class='row well'>";
exportar_excel($sql);
echo "<h4>Elementos Reparados</h4>";
echo '<div style=" height:300px; overflow:auto;">';
echo tabla_sql3($sql);
echo "</div>";
echo "</div>";

?>