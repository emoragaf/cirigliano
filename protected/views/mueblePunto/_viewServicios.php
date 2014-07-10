<?php
/* @var $this PuntoController */
/* @var $data Punto */
?>

<div class="well">
  
	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->descripcion),array('/ServicioMueble/view','id'=>$data->id)); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('tarifa')); ?>:</b>
	<?php echo CHtml::encode($data->tarifa); ?>
	<br />
</div>
	 