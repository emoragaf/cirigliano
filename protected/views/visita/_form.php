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
<br>
    <?php
    $this->widget('yiiwheels.widgets.multiselect.WhMultiSelect', array(
            'name' => 'selectMueblePunto',
            'data' => Chtml::ListData(MueblePunto::model()->findAll(array('condition'=>'punto_id ='.$model->punto_id)),'id','Descripcion'),
            'pluginOptions'=>array('nonSelectedText'=>'No hay muebles seleccionados'),
            'htmlOptions'=>array('onchange'=>'
                var notSelectedValues = [];
                var SelectedValues = $(this).val();
                $("#selectMueblePunto option:not(:selected)").each(function(i, selectedElement) {
                 notSelectedValues[i] = $(selectedElement).val();
                });
                
                console.log($(this).val());
                for (var i in notSelectedValues) {
                    $("#mueble"+notSelectedValues[i]).hide();
                }
                for (var j in SelectedValues) {
                    $("#mueble"+SelectedValues[j]).show();
                }'),
        ));
    ?>
    <br>
    <?php echo CHtml::link('Agregar mueble al punto', "",  // the link for open the dialog
    array(
        'style'=>'cursor: pointer; text-decoration: underline;',
        'onclick'=>"{addMueblePunto(); $('#dialogMueblePunto').dialog('open');}"));?>
 
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMueblePunto',
    'options'=>array(
        'title'=>'Agregar Mueble',
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
function addMueblePunto()
{
    <?php echo CHtml::ajax(array(
            'url'=>array('MueblePunto/AddNew','id'=>$model->punto_id),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogMueblePunto div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogMueblePunto div.divForForm form').submit(addMueblePunto);
                }
                else
                {
                    $('#dialogMueblePunto div.divForForm').html(data.div);
                    setTimeout(\"$('#dialogMueblePunto').dialog('close') \",3000);
                }
 
            } ",
            ))?>;
    return false; 
 
}
 
</script>
<?php if (!empty($muebles)): ?>
                
    <?php foreach ($muebles as $mueble): ?>
        <div style="display:none" id="mueble<?php echo $mueble->id?>">
            
        
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
        </div>
    <?php endforeach ?>
    <?php else: ?>
        Punto sin muebles asignados.
<?php endif ?>

    <div>
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->