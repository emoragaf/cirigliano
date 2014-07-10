<?php
/* @var $this PuntoController */
/* @var $model Punto */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
                    <?php echo $form->textFieldControlGroup($model,'direccion',array('span'=>5,'maxlength'=>45)); ?>
                    
                    <?php echo $form->dropDownListControlGroup($model, 'region_id',
                        CHtml::listData(Region::model()->findAll(array('order'=>'orden')), 'id', 'nombre'), array('empty' => 'Seleccione')); ?>

                    <?php echo $form->dropDownListControlGroup($model, 'canal_id',
                        CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('empty' => 'Seleccione')); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Buscar',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->