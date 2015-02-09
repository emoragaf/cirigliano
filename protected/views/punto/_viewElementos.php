<?php
/* @var $this PuntoController */
/* @var $data Punto */
?>

<div class="view">
<?php if (count($data) > 0): ?>
	<table class="table table-bordered table-condensed table-striped">
		<tr>
			<th>Elemento</th>
			<th>Tarifa</th>
		</tr>
		<?php foreach ($data as $key => $value): ?>
			<tr>
				<td><?php echo $value->descripcion; ?></td><td style="text-align:right"><?php echo $value->tarifa; ?></td>
			</tr>
		<?php endforeach ?>
	</table>
<?php endif ?>
</div>