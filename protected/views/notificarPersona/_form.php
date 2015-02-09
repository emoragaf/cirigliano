<?php
/* @var $this NotificarPersonaController */
/* @var $model NotificarPersona */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'notificar-persona-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($persona); ?>
	<div class="row">
		<div class="span3">
			<h4>Seleccionar</h4>
            <?php echo $form->dropDownListControlGroup($model, 'persona_id',
                CHtml::listData(Persona::model()->findAll(), 'id', 'nombre'), array('empty' => 'Seleccione')); ?>
		</div>
		<div class="span3">
            <h4>Agregar Persona</h4>
	    	<div class="row">
	    		 <?php echo $form->textFieldControlGroup($persona, 'nombre'); ?>
	    	</div>
	    	<div class="row">
	    		 <?php echo $form->textFieldControlGroup($persona, 'email'); ?>
	    	</div>
		</div>
	</div>

	
		<h4>Notificar</h4>	
			<?php echo TbHtml::checkBox('Tipo[1]', '', array('label' => 'Presupuesto Solicitud')); ?>
    		<?php echo TbHtml::checkBox('Tipo[2]', '', array('label' => 'Informe')); ?>
        <h4>Canal</h4>
			<?php echo TbHtml::dropDownList('opcion[canal]', '',CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),array('empty'=>'Todos') ); ?>
        <div class="form-actions">

        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->