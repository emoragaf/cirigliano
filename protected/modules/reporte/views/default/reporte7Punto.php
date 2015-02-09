<?php 
$sql = "SELECT
					wh_visita.folio as Folio,
					wh_visita.tipo_visita as TipoVisita,
					wh_visita.direccion_punto as Direccion, 
					comuna.nombre as Comuna,
					canal.nombre as Canal,
					distribuidor.nombre as Distribuidor,
					wh_visita.fecha_creacion as Fecha_Creacion,
					sum(wh_visita.cantidad_item*wh_visita.monto_item) as Monto 
				FROM wh_visita
				LEFT JOIN	comuna ON wh_visita.comuna = comuna.id
				LEFT JOIN	distribuidor ON wh_visita.distribuidor = distribuidor.id
				LEFT JOIN	canal ON wh_visita.canal = canal.id
				";
$sql .= " WHERE wh_visita.id > 0 \n";
//$sql .= " AND wh_visita.tipo_visita != 3 \n";
$sql .= $filtros;
$sql .="  group by folio, tipo_visita  ";
$sql .=" order by Direccion ASC,fecha_creacion DESC";
exportar_excel($sql);
echo "<h4>Lista por Visita</h4>";
echo '<div style=" height:300px; overflow:auto;">';
echo tabla_sql7($sql);
echo "</div>";
?>