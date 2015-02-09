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
	array('label'=>'Listado Histórico Reparaciones','url'=>array('index')),
);
?>

<h1>Detalle Reparación</h1>


<table class="table table-condensed">
<tr>
	<td colspan="3"><h4>Estado: <?php echo $model->idEstadoReparacion->descripcion  ?></h4></td>
</tr>
<tr>
	<td><b>Fecha Ingreso: <?php echo date("d-m-Y",strtotime($model->fecha_ingreso)) ?></b></td>
	<td><b>Fecha Ejecución: <?php echo $model->fecha_ejecucion !== null ? date("d-m-Y",strtotime($model->fecha_ejecucion)) : 'No asignado' ?></b></td>
	<td><b>Solicitante: <?php echo $model->idCargoSolicitante->descripcion?></b></td>
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
<h2>Datos Reparación</h2>
<?php if ($model->detalleReparacions): ?>
	<?php foreach ($model->detalleReparacions as $detalle): ?>
		<div class="well">
			<h4><?php echo $detalle->idMueble->descripcion ?></h4>
			<table class="table table-condensed table-bordered table-striped">
			<tr>
				<th>Descripcion</th>
				<th>Cantidad</th>
				<th>Tarifa</th>
				<th>Total</th>
			</tr>
			<?php foreach ($detalle->presupuestoReparacionNormals as $pnormal): ?>
				<tr>
					<td>
						<?php echo $pnormal->idPrecioReparacion->descripcion; ?>
					</td>
					<td>
						<?php echo $pnormal->cantidad; ?>
					</td>
					<td>
					<?php if ($pnormal->cantidad <= 5 && $pnormal->idPrecioReparacion->mano_de_obra_rango_1>0 ): ?>
						<?php echo $pnormal->idPrecioReparacion->mano_de_obra_rango_1; ?>
					<?php endif ?>
					<?php if ($pnormal->cantidad > 5 && $pnormal->cantidad <= 10 && $pnormal->idPrecioReparacion->mano_de_obra_rango_2>0): ?>
						<?php echo $pnormal->idPrecioReparacion->mano_de_obra_rango_2; ?>
					<?php endif ?>
					<?php if ($pnormal->cantidad > 10 && $pnormal->idPrecioReparacion->mano_de_obra_rango_3>0): ?>
						<?php echo $pnormal->idPrecioReparacion->mano_de_obra_rango_3; ?>
					<?php endif ?>
					<?php if ($pnormal->idPrecioReparacion->mano_de_obra_rango_1 == 0 && $pnormal->idPrecioReparacion->mano_de_obra_rango_2 == 0 && $pnormal->idPrecioReparacion->mano_de_obra_rango_3 == 0 ): ?>
						<?php echo $pnormal->idPrecioReparacion->material; ?>
					<?php endif ?>
						
					</td>
					<td>
					<?php if ($pnormal->cantidad <= 5 && $pnormal->idPrecioReparacion->mano_de_obra_rango_1>0): ?>
						<?php echo $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_1; ?>
					<?php endif ?>
					<?php if ($pnormal->cantidad > 5 && $pnormal->cantidad <= 10 && $pnormal->idPrecioReparacion->mano_de_obra_rango_2>0): ?>
						<?php echo $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_2; ?>
					<?php endif ?>
					<?php if ($pnormal->cantidad > 10 && $pnormal->idPrecioReparacion->mano_de_obra_rango_3>0): ?>
						<?php echo $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_3; ?>
					<?php endif ?>
					<?php if ($pnormal->idPrecioReparacion->mano_de_obra_rango_1 == 0 && $pnormal->idPrecioReparacion->mano_de_obra_rango_2 == 0 && $pnormal->idPrecioReparacion->mano_de_obra_rango_3 == 0 && $pnormal->idPrecioReparacion->material>0): ?>
						<?php echo $pnormal->cantidad*$pnormal->idPrecioReparacion->material; ?>
					<?php endif ?>
					<?php if ($pnormal->idPrecioReparacion->mano_de_obra_rango_1 == 0 && $pnormal->idPrecioReparacion->mano_de_obra_rango_2 == 0 && $pnormal->idPrecioReparacion->mano_de_obra_rango_3 == 0 && $pnormal->idPrecioReparacion->material==0 && $pnormal->idPrecioReparacion->transporte>0 ): ?>
						<?php echo $pnormal->cantidad*$pnormal->idPrecioReparacion->transporte; ?>
					<?php endif ?>
						
					</td>
				</tr>
			<?php endforeach ?>
			<?php foreach ($detalle->presupuestoReparacionAdicionals as $padicional): ?>
				<tr>
					<td>
						<?php echo $padicional->elemento; ?>
					</td>
					<td>
						<?php echo $padicional->cantidad; ?>
					</td>
					<td>
						<?php  
							if($padicional->mano_de_obra>0){
								echo $padicional->mano_de_obra;
							}
							if($padicional->mano_de_obra == 0 && $padicional->material>0){
								echo $padicional->material;
							}
							if($padicional->mano_de_obra == 0 && $padicional->material == 0 && $padicional->transporte>0){
								echo $padicional->transporte;
							}
						?>
					</td>
					<td>
						<?php  
							if($padicional->mano_de_obra>0){
								echo $padicional->cantidad*$padicional->mano_de_obra;
							}
							if($padicional->mano_de_obra == 0 && $padicional->material>0){
								echo $padicional->cantidad*$padicional->material;
							}
							if($padicional->mano_de_obra == 0 && $padicional->material == 0 && $padicional->transporte>0){
								echo $padicional->cantidad*$padicional->transporte;
							}
						?>
					</td>
				</tr>
			<?php endforeach ?>
			</table>
		</div>
	<?php endforeach ?>
	
<?php endif ?>
<h2>Fotos</h2>
<div class="row">
<?php foreach ($model->fotoReparacions as $freparacion): ?>
	<div class="span4">
		<h4><?php echo $freparacion->idTipoFotoReparacion->descripcion; ?></h4>
		<?php 
		echo '<img src="data:'.$freparacion->tipo.';base64,' . $freparacion->foto . '" />';
		?>
	</div>

<?php endforeach ?>
</div>
<div class="row">
	<?php foreach ($model->fotoSolicitudReparacions as $fsolicitud): ?>
		<div class="span4">
			<?php 
				echo '<img src="data:'.$fsolicitud->tipo.';base64,' . $fsolicitud->foto . '" />';
			?>
		</div>
	<?php endforeach ?>
</div>
<?php foreach ($model->detalleReparacions as $detalle): ?>
	<h3><?php echo $detalle->idMueble->descripcion ?></h3>
	<?php foreach ($detalle->presupuestoReparacionNormals as $pnormal): ?>
		<div class="row">
			<?php foreach ($pnormal->fotoReparacionNormals as $fReparacionNormal): ?>
				<div class="span4">
					<h4><?php echo $fReparacionNormal->idTipoFotoReparacion->descripcion; ?></h4>
					<?php 
					echo '<img src="data:'.$fReparacionNormal->tipo.';base64,' . $fReparacionNormal->foto . '" />';
					?>
				</div>
			<?php endforeach ?>
		</div>
	<?php endforeach ?>
	<br>
	<?php foreach ($detalle->presupuestoReparacionAdicionals as $padicional): ?>
		<div class="row">
			<?php foreach ($padicional->fotoReparacionAdicionals as $fReparacionAdicional): ?>
				<div class="span4">
					<h4><?php echo $fReparacionAdicional->idTipoFotoReparacion->descripcion; ?></h4>
					<?php 
						echo '<img src="data:'.$fReparacionAdicional->tipo.';base64,' . $fReparacionAdicional->foto . '" />';
					?>
				</div>
			<?php endforeach ?>
		</div>
	<?php endforeach ?>
<?php endforeach ?>