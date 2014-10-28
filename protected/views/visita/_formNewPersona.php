<?php
/* @var $this MueblePuntoController */
/* @var $model MueblePunto */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'mueble-punto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

    
	
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($persona); ?>
    <?php if ($alert != ''): ?>
    	<?php echo TbHtml::em($alert, array('color' => TbHtml::TEXT_COLOR_ERROR)); ?>
    <?php endif ?>
    <h4>Seleccionar Existente</h4>
    	<div class="row">
	       	<?php  
	       		$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
				'model' => $model,
				'attribute'=>'persona_id',
				'data' => array(''=>'') + CHtml::listData(Persona::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				'pluginOptions' => array(
		            'placeholder' => 'Persona',
		            'width' => '100%',
		            
	        	)
			));  ?>
    		
    	</div>
    	<hr>
    	<h4>Nuevo</h4>
    	<div class="row">
    		 <?php echo $form->textFieldControlGroup($persona, 'nombre'); ?>
    	</div>
    	<div class="row">
    		 <?php echo $form->textFieldControlGroup($persona, 'email'); ?>
    	</div>
       
        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Agregar' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->