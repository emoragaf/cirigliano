<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form TbActiveForm */
    $mps = CHtml::ListData(MueblePunto::model()->findAll(array('condition'=>'punto_id ='.$id)),'id','Descripcion');
?>
    <?php
    if(!empty($mps)){
    $this->widget('yiiwheels.widgets.multiselect.WhMultiSelect', array(
            'name' => 'selectMueblePunto',
            'data' => CHtml::ListData(MueblePunto::model()->findAll(array('condition'=>'punto_id ='.$id)),'id','Descripcion'),
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
    }
    else{

    echo 'Punto sin muebles asignados.';
    }
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
            'url'=>array('MueblePunto/AddNew','id'=>$id),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"js:function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogMueblePunto div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogMueblePunto div.divForForm form').submit(addMueblePunto);
                }
                else
                {   
                    $.ajax({
                        url: '".CController::createAbsoluteUrl('Visita/UpdateMueblesPunto', array('id' => $id))."',
                        success : function(data) {
                            $('#dialogMueblePunto').dialog('close');
                            $('#mueblepunto').html(data);
                            //$('#selectMueblePunto').multiselect('refresh');

                        }
                    });
                    //$('.multiselect-container.dropdown-menu').append(data.div);
                    
                }
 
            } ",
            ))?>;
    return false; 
 
}
 
</script>
<?php if (!empty($muebles)): ?>
                
    <?php foreach ($muebles as $mueble): ?>
        <div style="display:none" id="mueble<?php echo $mueble->id?>">
            
        
        <h3><?php echo $mueble->mueble->descripcion.'</h3>Cód.'.$mueble->codigo; ?>
            <?php if (!empty($mueble->servicioMuebles)): ?>
            <table class="table table-striped table-bordered table-condensed">
                <tr>
                    <th>Cantidad</th>
                    <th>Item</th>
                    <th>Tarifa</th>
                </tr>
                <?php foreach ($mueble->servicioMuebles as $servicio): ?>
                <tr>
                    <td>
                    <input type="number" id="Mueble<?php echo $mueble->id?>-<?php echo $servicio->id?>" name="Mueble[<?php echo $mueble->id?>][<?php echo $servicio->id?>]" min="0" value="0" style="width:30px;" 
                    onchange="var cant = $('#Mueble<?php echo $mueble->id?>-<?php echo $servicio->id?>').val();
                               if(cant < <?php echo  $servicio->cant_b;?>){
                                $('#Tarifa<?php echo $mueble->id?>-<?php echo $servicio->id?>').html(cant*<?php echo $servicio->tarifa;?>);
                               }
                               if(cant >= <?php echo  $servicio->cant_b;?> && cant < <?php echo  $servicio->cant_c;?>){
                                $('#Tarifa<?php echo $mueble->id?>-<?php echo $servicio->id?>').html(cant*<?php echo $servicio->tarifa_b;?>);
                               }
                               if(cant >= <?php echo  $servicio->cant_c;?>){
                                $('#Tarifa<?php echo $mueble->id?>-<?php echo $servicio->id?>').html(cant*<?php echo $servicio->tarifa_c;?>);
                               }">
                    </td>
                    <td><?php echo $servicio->descripcion;?></td>
                    <td><span id="Tarifa<?php echo $mueble->id?>-<?php echo $servicio->id?>">0</span></td>
                </tr>
                <?php endforeach ?>
            </table>
            <br>
            <script type="text/javascript">
            var i =0;
            </script>
            <table class="table table-bordered table-condensed" id="adicionales<?php echo $mueble->id?>">
                <tr>
                    <th width="25px;">
                    <?php echo TbHtml::button(TbHtml::icon(TbHtml::ICON_PLUS).' Agregar', array('color' => TbHtml::BUTTON_COLOR_INFO,'onclick'=>"i++; $('#adicionales".$mueble->id." tr:last').after('<tr><td><input placeholder=\"Descripción\" type=\"text\" value=\"\" name=\"Adicional[".$mueble->id."][adicional' + i + '][descripcion]\" id=\"Adicional_".$mueble->id."_adicional' + i + '_descripcion\"></td><td><input placeholder=\"Tarifa\" type=\"text\" value=\"\" name=\"Adicional[".$mueble->id."][adicional' + i + '][tarifa]\" id=\"Adicional_".$mueble->id."_adicional' + i + '_tarifa\"></td></tr>');
")); ?>
                    </th>
                    <th colspan="2"> Adicionales</th>
                </tr>
                <tr>
                    <td>
                                <?php echo TbHtml::textField('Adicional['.$mueble->id.'][adicional0][descripcion]', '', array('placeholder' => 'Descripción')); ?>

                    </td>
                    <td>
                                <?php echo TbHtml::textField('Adicional['.$mueble->id.'][adicional0][tarifa]', '', array('placeholder' => 'Tarifa')); ?>

                    </td>
                </tr>
            </table>   
            <?php endif ?>
        </div>
    <?php endforeach ?>
    <?php else: ?>
        
<?php endif ?>
<br>
<br>
    <div>
        <?php echo TbHtml::submitButton('Aceptar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?>
    </div>
