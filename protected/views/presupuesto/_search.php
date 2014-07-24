<?php
/* @var $this PresupuestoController */
/* @var $model Presupuesto */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'total',array('span'=>5,'maxlength'=>45)); ?>

                    <?php echo $form->textAreaControlGroup($model,'nota',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'visita_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'user_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'estado',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha_creacion',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha_respuesta',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha_asignacion',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'fecha_termino',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Buscar',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->