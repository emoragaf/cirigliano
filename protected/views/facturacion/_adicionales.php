<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'dataProvider' => $adicionalesDataProvider,
   'type'=>TbHtml::GRID_TYPE_BORDERED,
   'columns' => array(
       'descripcion',
        array(
            'name' => 'monto',
            'value' => 'Yii::app()->numberFormatter->format("###,###,###,###",$data->monto);',
        ),
    ),
)); ?>
<div class="row">
        <h3>Nuevo Adicional</h3>
        <?php 
            $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array( 
                'enableAjaxValidation'=>true, 'id'=>'formulario-form',
            ));
        ?>
        <input type="hidden" name="adicional[periodo]" value="<?php echo $mes ?>">
        <div class="span2">
            <?php echo TbHtml::textField('adicional[descripcion]','',array('placeholder'=>'Descripción')); ?>
        </div>
        <div class="span2">
            <?php echo TbHtml::textField('adicional[monto]','',array('placeholder'=>'Monto')); ?>
        </div>

        <div class="span1">
            <?php echo TbHtml::submitButton('Aceptar'); ?>
        </div>

        <?php $this->endWidget(); ?>
</div>
