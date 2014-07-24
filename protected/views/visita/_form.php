<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'visita-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <!--<p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>-->

    <?php echo $form->errorSummary($model); ?>
            <label for="punto_id">Tipo Visita</label>
            <select name="Visita[tipo_visita_id]" id="">
                <option value="1">Reparación</option>
                <option value="2">Limpieza</option>
                <option value="3">Visita Preventiva</option>
            </select>

            <?php echo $form->dropDownListControlGroup($model, 'persona_punto_id',
                CHtml::listData(PersonaPunto::model()->findAll(array('condition'=>'punto_id = '.$model->punto_id)), 'id', 'Nombre'), array('empty' => 'Seleccione')); ?>

    <div>
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->