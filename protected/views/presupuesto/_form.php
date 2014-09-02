
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
                            <th>Cantidad</th>
                            <th>Item</th>
                            <th>Tarifa 1</th>
                            <th>Tarifa 2</th>
                            <th>Tarifa 3</th>
                        </tr>
                        <?php foreach ($mueble->servicioMuebles as $servicio): ?>
                        <tr>
                            <td>
                            <input type="number" name="Mueble[<?php echo $mueble->id?>][<?php echo $servicio->id?>]" min="0" value="0" style="width:30px;">
                            </td>
                            <td><?php echo $servicio->descripcion;?></td>
                            <td><?php echo $servicio->tarifa;?> (1 a <?php echo  $servicio->cant_b;?>)</td>
                            <td><?php echo $servicio->tarifa_b;?> (<?php echo  $servicio->cant_b+1;?> a <?php echo  $servicio->cant_c;?>)</td>
                            <td><?php echo $servicio->tarifa_c;?> (Más de <?php echo  $servicio->cant_c;?>)</td>
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