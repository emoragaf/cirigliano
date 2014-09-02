<?php
/* @var $this FormularioController */
/* @var $data Formulario */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notas')); ?>:</b>
	<?php echo CHtml::encode($data->notas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visita_id')); ?>:</b>
	<?php echo CHtml::encode($data->visita_id); ?>
	<br />


</div>