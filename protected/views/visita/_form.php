<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form TbActiveForm */
$filtroTipos = array();
if($model->tipo_visita_id != 3){
    $filtroTipos = CHtml::listData(TipoVisita::model()->findAll(array('condition'=>'id = 1 or id = 2','order'=>'nombre')),'id','nombre');
}
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

        <?php if($model->tipo_visita_id != 3){ ?>
            <?php echo $form->dropDownListControlGroup($model, 'tipo_visita_id',
                $filtroTipos, array('empty' => 'Seleccione')); ?>
        <?php } ?>
            <?php echo $form->dropDownListControlGroup($model, 'persona_punto_id',
                CHtml::listData(PersonaPunto::model()->findAll(array('condition'=>'punto_id = '.$model->punto_id)), 'id', 'Nombre'), array('empty' => 'Seleccione')); ?>

            <label>Fecha Tentativa</label>

            <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
        'model'=>$model,
        'attribute'=>'fecha_visita',
        'name' => 'Visita[fecha_visita]',
        'pluginOptions' => array(
            'format' => 'dd-mm-yyyy',
            'language'=>'es',
        )
    ));
?>
 

    <div>
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->