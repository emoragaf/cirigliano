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
    <?php if($model->tipo_visita_id != 3){ ?>
        <div class="span3">
            <?php echo $form->dropDownListControlGroup($model, 'tipo_visita_id',
                $filtroTipos, array('empty' => 'Seleccione')); ?>
            <?php echo $form->checkBoxControlGroup($model, 'visita_preventiva', array()); ?>
        </div>
    <?php } ?>

    <div class="span3">
         <?php echo $form->dropDownListControlGroup($model, 'persona_punto_id',
            CHtml::listData(PersonaPunto::model()->findAll(array('condition'=>'punto_id = '.$model->punto_id)), 'id', 'Nombre'), array('empty' => 'Seleccione')); ?>
        <?php echo CHtml::link('Agregar Solicitante', "",  // the link for open the dialog
        array(
            'style'=>'cursor: pointer; text-decoration: underline;',
            'onclick'=>"{addPersonaPunto(); $('#dialogPersonaPunto').dialog('open');}"));?>
    </div>
    <?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPersonaPunto',
    'options'=>array(
        'title'=>'Agregar Solicitante',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>470,
    ),
));?>
<div class="divForForm"></div>
 
<?php $this->endWidget();?>
 
<script type="text/javascript">
// here is the magic
function addPersonaPunto()
{
    <?php echo CHtml::ajax(array(
            'url'=>array('Visita/AddNewPersonaPunto','id'=>$id),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"js:function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogPersonaPunto div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogPersonaPunto div.divForForm form').submit(addPersonaPunto);
                }
                else
                {   
                    $('#dialogPersonaPunto').dialog('close');
                    $('#Visita_persona_punto_id').append(data.div);
                    
                }
 
            } ",
            ))?>;
    return false; 
 
}
 
</script>
    <div class="span3">
        <label>Fecha Tentativa</label>
        <?php 
        $this->widget('zii.widgets.jui.CJuiDatePicker',
        array(
                'name'=>'Visita[fecha_visita]',
                'language'=>'es',
                'value'=>date('d-m-Y',strtotime($model->fecha_visita)),
                // additional javascript options for the date picker plugin
                'options'=>array('showAnim'=>'fold','dateFormat' => 'dd-mm-yy',),
                'htmlOptions'=>array('style'=>'height:20px;'),
                        
        ));
        ?>
    </div>
</div>
        
       
        
