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
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>
        
        <?php echo $form->dropDownListControlGroup($model, 'mueble_id',
                CHtml::listData(Mueble::model()->findAll(array('order'=>'descripcion')), 'id', 'descripcion'), array('empty' => 'Seleccione')); ?>
        
        <?php echo $form->textFieldControlGroup($model,'codigo',array('span'=>5,'maxlength'=>45)); ?>
        
        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Agregar' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->