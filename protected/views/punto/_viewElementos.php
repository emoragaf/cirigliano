<?php
/* @var $this PuntoController */
/* @var $data Punto */
?>

<div class="view">
<?php if (count($data) > 0): ?>
	<ul>
		<?php foreach ($data as $key => $value): ?>
			<li><?php echo $value->descripcion.' - '.$value->tarifa; ?></li>
		<?php endforeach ?>
	</ul>
<?php endif ?>
</div>