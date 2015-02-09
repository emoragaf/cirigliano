<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form TbActiveForm */
    $mps = CHtml::ListData(MueblePunto::model()->findAll(array('condition'=>'punto_id ='.$id)),'id','Descripcion');
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
                        url: '".CController::createAbsoluteUrl('Visita/UpdateMueblesPuntoTraslado', array('id' => $id))."',
                        success : function(data) {
                            $('#dialogMueblePunto').dialog('close');
                            $('#mueblepunto').html(data);
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
        <table class="table table-condensed table-bordered">
            <tr>
                <th>Seleccionar</th>
                <th>Mueble</th>
                <th>Instalación</th>
                <th>Desinstalación</th>
                <th>Tarifa Instalación/Desinstalación</th>
            </tr>
            <?php foreach ($muebles as $mueble): ?>
                <tr>
                    <td style="width:50px;">
                        <input type="checkbox" id="Mueble[<?php echo $mueble->id?>]" name="Mueble[<?php echo $mueble->id?>]" onclick="
                        if (this.checked) 
                        {
                            console.log('checked!');
                            $('#i_<?php echo $mueble->id?>').show();
                        } 
                        else 
                        {   
                            console.log('not checked!');
                            $('#i_<?php echo $mueble->id?>').hide();
                        }">
                    </td>
                    <td>
                        <?php echo $mueble->mueble->descripcion.' '.$mueble->codigo;?>
                    </td>
                    <td>
                        <input type="checkbox" id="Instalacion[<?php echo $mueble->id?>]" name="Instalacion[<?php echo $mueble->id?>]">
                    </td>
                    <td>
                        <input type="checkbox" id="Desinstalacion[<?php echo $mueble->id?>]" name="Desinstalacion[<?php echo $mueble->id?>]">
                    </td>
                    <td>
                        <div style="display:none" id="i_<?php echo $mueble->id?>">
                            <?php 
                                $tarifa = TarifaInstalacion::model()->find(array('condition'=>'mueble_id ='.$mueble->mueble_id.' AND activo =1'));
                                if($tarifa)
                                    echo $tarifa->tarifa_a;
                                else{
                                    $tarifa = TarifaInstalacion::model()->find(array('condition'=>'mueble_id ='.$mueble->mueble->categoria_precio.' AND activo =1'));
                                    if($tarifa)
                                        echo $tarifa->tarifa_a;
                                }
                                ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>        
    <?php else: ?>
        Punto sin muebles asignados.
<?php endif ?>
<br>
<br>
    <div>
        <?php echo TbHtml::submitButton('Aceptar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		)); ?>
    </div>
