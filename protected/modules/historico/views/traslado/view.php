<?php
/* @var $this VisitaController */
/* @var $model Visita */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Visita')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listado Histórico Traslados','url'=>array('index')),
);
?>

<h1>Detalle Traslado</h1>


<table class="table table-condensed">
<tr>
	<td colspan="3"><h4>Estado: <?php echo $model->idEstadoTransporte->descripcion  ?></h4></td>
</tr>
<tr>
	<td><b>Fecha Ingreso: <?php echo date("d-m-Y",strtotime($model->fecha_ingreso)) ?></b></td>
	<td><b>Fecha Ejecución: <?php echo $model->fecha_ejecucion !== null ? date("d-m-Y",strtotime($model->fecha_ejecucion)) : 'No asignado' ?></b></td>
</tr>
</table>
<h2>Datos Punto</h2>
<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-bordered',
    ),
    'data'=>$model,
    'attributes'=>array(
			array(
				'name'=>'punto_direccion',
				'value'=>$model->idPunto->direccion,
				),
			array(
				'name'=>'punto_canal_id',
				'value'=>isset($model->idPunto->idCanal) ? $model->idPunto->idCanal->descripcion: null,
				),
			array(
				'name'=>'punto_distribuidor_id',
				'value'=>isset($model->idPunto->idDistribuidor) ? $model->idPunto->idDistribuidor->descripcion: null,
				),
			array(
				'name'=>'punto_comuna_id',
				'value'=>isset($model->idPunto->idComuna) ? $model->idPunto->idComuna->nombre :null,
				),
	),
)); ?>
<h2>Datos Traslado</h2>
<?php if ($model->detalleTransportes): ?>
	<?php foreach ($model->detalleTransportes as $detalle): ?>
		<div class="well">
			<h4><?php echo $detalle->idMueble->descripcion ?></h4>
			<table class="table table-condensed table-bordered table-striped">
			<tr>
				<th>Descripcion</th>
				<th>Cantidad</th>
				<th>Tarifa</th>
				<th>Total</th>
			</tr>
			<?php if ($detalle->presupuestoTransportes): ?>
				<?php foreach ($detalle->presupuestoTransportes as $pnormal): ?>
					<tr>
						<td>
							<?php echo $pnormal->observaciones; ?>
						</td>
						<td>
							<?php echo $detalle->cantidad; ?>
						</td>
						<td>
							<?php echo $pnormal->valor_unitario; ?>
						</td>
						<td>
							<?php echo $pnormal->valor_unitario*$pnormal->cantidad; ?>	
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
			<?php if ($detalle->rutaTransportes): ?>
				<?php foreach ($detalle->rutaTransportes as $pnormal): ?>
					<tr>
						<td>
							<?php echo $pnormal->idPrecioTransporte->origen.' - '.$pnormal->idPrecioTransporte->destino; ?>
						</td>
						<td>
							<?php echo $detalle->cantidad; ?>
						</td>
						<td>
							<?php 
								$valor = 0;
								if ($pnormal->medio == 1) {
									$valor = $pnormal->idPrecioTransporte->valor1;
								}
								if ($pnormal->medio == 2) {
									$valor = $pnormal->idPrecioTransporte->valor2;
								}
								if ($pnormal->medio == 3) {
									$valor = $pnormal->idPrecioTransporte->valor3;
								}
								if ($pnormal->medio == 4) {
									$valor = $pnormal->idPrecioTransporte->valor4;
								}
						 	?>
							<?php echo $valor; ?>
						</td>
						<td>
							<?php echo $valor*$detalle->cantidad; ?>	
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
			<?php if ($detalle->rutaTransporteUnos): ?>
				<?php foreach ($detalle->rutaTransporteUnos as $pnormal): ?>
					<tr>
						<td>
							<?php echo $pnormal->idPrecioTransporteUno->origen.' '.$pnormal->idPrecioTransporteUno->destino; ?>
						</td>
						<td>
							<?php echo $detalle->cantidad; ?>
						</td>
						<td>
							<?php echo $pnormal->idPrecioTransporteUno->valor; ?>
						</td>
						<td>
							<?php echo $pnormal->idPrecioTransporteUno->valor*$detalle->cantidad; ?>	
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
			<?php if ($detalle->rutaTransporteDoses): ?>
				<?php foreach ($detalle->rutaTransporteDoses as $pnormal): ?>
					<tr>
						<td>
							<?php echo $pnormal->tipo; ?>
						</td>
						<td>
							<?php echo $detalle->cantidad; ?>
						</td>
						<td>
							<?php
								if ($pnormal->tipo == 'TRASLADO') {
									echo $pnormal->idPrecioTransporteDos->traslado;
								}
								if ($pnormal->tipo == 'INSTALACION') {
									echo $pnormal->idPrecioTransporteDos->instalacion;
								}
								if ($pnormal->tipo == 'RETIRO') {
									echo $pnormal->idPrecioTransporteDos->retiro;
								}
								if ($pnormal->tipo == 'INSTALACIONRETIRO') {
									echo $pnormal->idPrecioTransporteDos->instalacionretiro;
								}
							?>
						</td>
						<td>
							<?php
								if ($pnormal->tipo == 'TRASLADO') {
									echo $pnormal->idPrecioTransporteDos->traslado*$detalle->cantidad;
								}
								if ($pnormal->tipo == 'INSTALACION') {
									echo $pnormal->idPrecioTransporteDos->instalacion*$detalle->cantidad;
								}
								if ($pnormal->tipo == 'RETIRO') {
									echo $pnormal->idPrecioTransporteDos->retiro*$detalle->cantidad;
								}
								if ($pnormal->tipo == 'INSTALACIONRETIRO') {
									echo $pnormal->idPrecioTransporteDos->instalacionretiro*$detalle->cantidad;
								}
							?>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>

			</table>
		</div>
	<?php endforeach ?>	
<?php endif ?>
<?php if ($model->fotoTransportes && $model->fotoSolicitudTransportes): ?>
<h2>Fotos</h2>
<?php else: ?>
<h3>No hay fotos disponibles.</h3>
<?php endif ?>

<div class="row">
<?php if ($model->fotoTransportes): ?>
	<?php foreach ($model->fotoTransportes as $freparacion): ?>
		<div class="span4">
			<h4><?php echo $freparacion->observaciones; ?></h4>
			<?php 
			echo '<img src="data:'.$freparacion->tipo.';base64,' . $freparacion->foto . '" />';
			?>
		</div>

	<?php endforeach ?>
<?php endif ?>
</div>
<div class="row">
	<?php if ($model->fotoSolicitudTransportes): ?>
		<?php foreach ($model->fotoSolicitudTransportes as $fsolicitud): ?>
			<div class="span4">
				<?php 
					echo '<img src="data:'.$fsolicitud->tipo.';base64,' . $fsolicitud->foto . '" />';
				?>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>