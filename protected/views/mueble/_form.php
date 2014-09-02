<?php
/* @var $this MuebleController */
/* @var $model Mueble */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'mueble-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'codigo',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'descripcion',array('span'=>5,'maxlength'=>45)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->