<?php
/* @var $this AdicionalController */
/* @var $model Adicional */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'mueble_presupuesto_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'tarifa',array('span'=>5,'maxlength'=>45)); ?>

                    <?php echo $form->textFieldControlGroup($model,'descripcion',array('span'=>5,'maxlength'=>45)); ?>

                    <?php echo $form->textFieldControlGroup($model,'mueble_punto_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'estado',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha_termino',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'foto_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'cantidad',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Buscar',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->