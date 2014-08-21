<?php
/* @var $this CampoFormularioController */
/* @var $data CampoFormulario */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_visita_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_visita_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_campo_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_campo_id); ?>
	<br />


</div>