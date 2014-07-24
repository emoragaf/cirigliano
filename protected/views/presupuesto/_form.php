<?php
/* @var $this PresupuestoController */
/* @var $model Presupuesto */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'presupuesto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>

            <?php if (!empty($muebles)): ?>
                
                <?php foreach ($muebles as $mueble): ?>
                <h3><?php echo $mueble->mueble->descripcion.' '.$mueble->codigo; ?></h3>
                    <?php if (!empty($mueble->servicioMuebles)): ?>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Seleccionar</th>
                            <th>Item</th>
                            <th>Tarifa</th>
                        </tr>
                        <?php foreach ($mueble->servicioMuebles as $servicio): ?>
                        <tr>
                            <td><?php echo CHtml::checkBox('Mueble['.$mueble->id.']['.$servicio->id.']', false, array('value'=>$servicio->id)); ?></td>
                            <td><?php echo $servicio->descripcion;?></td>
                            <td><?php echo $servicio->tarifa;?></td>
                        </tr>
                        <?php endforeach ?>
                    </table>   
                    <?php else: ?>
                        Mueble sin elementos licitados para reparar.
                    <?php endif ?>

                <?php endforeach ?>
                <?php else: ?>
                    Punto sin muebles asignados.
            <?php endif ?>
            <?php echo $form->textAreaControlGroup($model,'nota',array('rows'=>6,'span'=>8)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->