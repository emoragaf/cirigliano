<?php
/* @var $this VisitaController */
/* @var $data Visita */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organizacion_id')); ?>:</b>
	<?php echo CHtml::encode($data->organizacion_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visitador_id')); ?>:</b>
	<?php echo CHtml::encode($data->visitador_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visitado_id')); ?>:</b>
	<?php echo CHtml::encode($data->visitado_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_programada')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_programada); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_realizada')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_realizada); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notas')); ?>:</b>
	<?php echo CHtml::encode($data->notas); ?>
	<br />


</div>