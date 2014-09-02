<?php
/* @var $this AdicionalController */
/* @var $data Adicional */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mueble_presupuesto_id')); ?>:</b>
	<?php echo CHtml::encode($data->mueble_presupuesto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tarifa')); ?>:</b>
	<?php echo CHtml::encode($data->tarifa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mueble_punto_id')); ?>:</b>
	<?php echo CHtml::encode($data->mueble_punto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_termino')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_termino); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('foto_id')); ?>:</b>
	<?php echo CHtml::encode($data->foto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad); ?>
	<br />

	*/ ?>

</div>