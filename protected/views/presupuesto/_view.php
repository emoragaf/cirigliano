<?php
/* @var $this PresupuestoController */
/* @var $data Presupuesto */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nota')); ?>:</b>
	<?php echo CHtml::encode($data->nota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visita_id')); ?>:</b>
	<?php echo CHtml::encode($data->visita_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_creacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_respuesta')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_respuesta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_asignacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_asignacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_termino')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_termino); ?>
	<br />

	*/ ?>

</div>