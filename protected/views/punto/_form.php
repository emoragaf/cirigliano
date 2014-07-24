<?php
/* @var $this PuntoController */
/* @var $model Punto */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'punto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'direccion',array('span'=>5,'maxlength'=>45)); ?>

            <?php echo $form->textFieldControlGroup($model,'lat',array('span'=>5,'maxlength'=>10)); ?>

            <?php echo $form->textFieldControlGroup($model,'lon',array('span'=>5,'maxlength'=>10)); ?>

            <?php echo $form->dropDownListControlGroup($model, 'region_id',
                CHtml::listData(Region::model()->findAll(array('order'=>'orden')), 'id', 'nombre'), array('empty' => 'Seleccione')); ?>

             <?php echo $form->dropDownListControlGroup($model, 'canal_id',
                CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('empty' => 'Seleccione')); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->