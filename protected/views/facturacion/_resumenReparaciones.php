<?php 
//$estados = array(0=>'Solicitada',1=>'Espera Aprobación Presupuesto',2=>'Presupuesto Rechazado',3=>'En Ejecución',4=>'Terminada',99=>'Cancelada');
	$totalAdicionales = 0;
	foreach ($adicionales as $adicional) {
		if($adicional)
			$totalAdicionales +=$adicional->monto;
	}
	$subtotales = array('reparaciones'=>array('total'=>0,'espPresup'=>0,'finalizados'=>0),'traslados'=>array('total'=>0,'espPresup'=>0,'finalizados'=>0));
	foreach ($presupuestos as $presupuesto) {
		if($presupuesto->visita->tipo_visita_id == 3){
			$subtotales['traslados']['total'] += $presupuesto->total;
			if($presupuesto->visita->estado == 1){
				$subtotales['traslados']['espPresup'] += $presupuesto->total;
			}
			if($presupuesto->visita->estado == 4){
				$subtotales['traslados']['finalizados'] += $presupuesto->total;
			}
		}
		if($presupuesto->visita->tipo_visita_id != 3){
			$subtotales['reparaciones']['total'] += $presupuesto->total;
			if($presupuesto->visita->estado == 1){
				$subtotales['reparaciones']['espPresup'] += $presupuesto->total;
			}
			if($presupuesto->visita->estado == 4){
				$subtotales['reparaciones']['finalizados'] += $presupuesto->total;
			}
		}
	}

 ?>
<div class="row">
	<div class="span12">
		<table class="table table-condensed table-bordered">
			<tr>
				<th>Item</th>
				<th class="span4">Espera Aprobacion Presupuesto</th>
				<th class="span2">Finalizados</th>
				<th class="span2">Total</th>
			</tr>
			<tr>
				<td>Reparación</td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['reparaciones']['espPresup']); ?></td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['reparaciones']['finalizados']); ?></td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['reparaciones']['espPresup']+$subtotales['reparaciones']['finalizados']); ?></td>
			</tr>
			<tr>
				<td>Traslado</td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['traslados']['espPresup']); ?></td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['traslados']['finalizados']); ?></td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['traslados']['finalizados']+$subtotales['traslados']['espPresup']); ?></td>
			</tr>
			<tr>
				<td colspan="3">Adicionales</td>
				<td ><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$totalAdicionales); ?></td>
			</tr>
			<tr>
				<td><b>Total</b></td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['traslados']['espPresup']+$subtotales['reparaciones']['espPresup']); ?></td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['traslados']['finalizados']+$subtotales['reparaciones']['finalizados']); ?></td>
				<td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['traslados']['total']+$subtotales['reparaciones']['total']); ?></td>
			</tr>
		</table>
	</div>
</div>
<br>
<div class="row">
	<div class="span12 well">
		<p><b>Neto: </b><?php echo(Yii::app()->numberFormatter->format('###,###,###,###',$subtotales['traslados']['total']+$subtotales['reparaciones']['total']));?></p>
		<p><b>IVA: </b><?php echo(Yii::app()->numberFormatter->format('###,###,###,###',0.19*($subtotales['traslados']['total']+$subtotales['reparaciones']['total'])));?></p>
		<p><b>Total: </b><?php echo(Yii::app()->numberFormatter->format('###,###,###,###',1.19*($subtotales['traslados']['total']+$subtotales['reparaciones']['total'])));?></p>
	</div>
</div>
<div class="row">
	<div class="span12 well">
		<p><b>Presupuesto Total: </b><?php echo Yii::app()->numberFormatter->format('###,###,###,###',20000000) ?></p>
		<p><b>Neto: </b><?php echo(Yii::app()->numberFormatter->format('###,###,###,###',($subtotales['traslados']['total']+$subtotales['reparaciones']['total'])));?></p>
		<p><b>Presupuesto Disponible: </b><?php echo(Yii::app()->numberFormatter->format('###,###,###,###',20000000-($subtotales['traslados']['total']+$subtotales['reparaciones']['total'])));?></p>
	</div>
</div>

<div class="row">
	
</div>