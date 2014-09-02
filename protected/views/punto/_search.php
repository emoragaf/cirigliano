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
                    <?php echo $form->dropDownListControlGroup($model, 'mueble',
                        CHtml::listData(MueblePunto::model()->findAll(array('condition'=>'punto_id = '.$model->id)), 'id', 'NombreMueble'), array('empty' => 'Seleccione')); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Buscar',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->