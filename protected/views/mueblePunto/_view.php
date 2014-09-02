<?php
/* @var $this MueblePuntoController */
/* @var $data MueblePunto */
?>

<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mueble_id')); ?>:</b>
	<?php echo CHtml::encode($data->mueble_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('punto_id')); ?>:</b>
	<?php echo CHtml::encode($data->punto_id); ?>
	<br />


</div>