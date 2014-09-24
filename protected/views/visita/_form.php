<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form TbActiveForm */
$filtroTipos = array();
if($model->tipo_visita_id != 3){
    $filtroTipos = CHtml::listData(TipoVisita::model()->findAll(array('condition'=>'id != 2 and id != 3','order'=>'id')),'id','nombre');
}
?>
    <!--<p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="span3">
        <?php if($model->tipo_visita_id != 3){ ?>
            <?php echo $form->dropDownListControlGroup($model, 'tipo_visita_id',
                $filtroTipos, array('empty' => 'Seleccione')); ?>
        <?php } ?>
        <?php echo $form->checkBoxControlGroup($model, 'visita_preventiva', array()); ?>

    </div>
    <div class="span3">
         <?php echo $form->dropDownListControlGroup($model, 'persona_punto_id',
            CHtml::listData(PersonaPunto::model()->findAll(array('condition'=>'punto_id = '.$model->punto_id)), 'id', 'Nombre'), array('empty' => 'Seleccione')); ?>

    </div>
    <div class="span3">
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
    </div>
</div>
        
       
        
