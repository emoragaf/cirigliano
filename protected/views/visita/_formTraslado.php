<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form TbActiveForm */
$tarifas = array();
foreach(TarifaTraslado::model()->findAll(array('condition'=>'activo=1')) as $tarifa){
    $tarifas[$tarifa->id] = array('1'=>$tarifa->tarifa_a,'2'=>$tarifa->tarifa_b,'3'=>$tarifa->tarifa_c,'4'=>$tarifa->tarifa_d,'5'=>$tarifa->tarifa_a2!=null?$tarifa->tarifa_a2:$tarifa->tarifa_a,'6'=>$tarifa->tarifa_b2!=null?$tarifa->tarifa_b2:$tarifa->tarifa_b,'7'=>$tarifa->tarifa_c2!=null?$tarifa->tarifa_c2:$tarifa->tarifa_c,'8'=>$tarifa->tarifa_d2!=null?$tarifa->tarifa_d2:$tarifa->tarifa_d);
}
?>
    <!--<p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>-->
<?php //print_r(json_encode($tarifas)) ?>
<?php echo $form->errorSummary($model); ?>
<div class="row well">
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
 <?php $tiv = $tarifaIV?'true':'false'; ?>
<div class="divForForm"></div>
 
<?php $this->endWidget();?>
 
<script type="text/javascript">
// here is the magic
function addPersonaPunto()
{
    <?php echo CHtml::ajax(array(
            'url'=>array('Visita/AddNewPersonaPunto','id'=>$model->punto_id),
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
                'value'=>date('d-m-Y'),
                // additional javascript options for the date picker plugin
                'options'=>array('showAnim'=>'fold','dateFormat' => 'dd-mm-yy',),
                'htmlOptions'=>array('style'=>'height:20px;'),
                        
        ));
        ?>
    </div>
    <div class="span3">
        <label>Código</label>
        <?php echo $form->textField($model, 'codigo'); ?>
    </div>
</div>

<div class="well">
    <div class="row">
            <div class="span3">
                <label>Punto Destino</label>
                <?php 
                    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                        'model' => $model,
                        'attribute'=>'destino_traslado_id',
                        'data' => array(''=>'Seleccione') + CHtml::listData(Punto::model()->findAll(array('order'=>'direccion')), 'id', 'DireccionDescripcion'),
                        'pluginOptions' => array(
                            'placeholder' => 'Destino',
                            'allowClear' => true,
                            'width' => '100%'
                        )
                        ));
                ?>
            </div>
            <div class="span3">
                <br>
                <?php echo TbHtml::checkBox('idavuelta', false, array('label' => 'Traslado Ida y Vuelta','disabled'=>$tarifaIV,'onclick'=>"
                if($('#Presupuesto_tarifa_traslado') && $('#Presupuesto_tarifa_traslado').val()){
                    var tarifas =".json_encode($tarifas).";
                    //console.log($('#Presupuesto_tarifa_traslado').val());
                    var ruta = $('#Presupuesto_tarifa_traslado').val();
                    var t = $('#Presupuesto_tipo_tarifa_traslado').val();
                    if($('#idavuelta').is(':checked') || ".$tiv."){
                        t =parseInt(t)+4;
                    }
                    $('#header_tarifa_traslado').text('Monto Traslado: ');
                    var list = '';
                    console.log(ruta);
                    $.each(ruta,function(index,data){
                        console.log(tarifas[data][t]);
                        if(tarifas[data][t] == null){
                            $('#tarifa_traslado').html(list);
                        }
                        if(tarifas[data][t] != null){
                            list = list + '<li>'+tarifas[data][t]+'</li>';
                            $('#tarifa_traslado').html(list);
                        }
                    });
                }",)); ?>
            </div>
    </div>
    <br>
    <div class="row">
        <div class="span5">
             <?php echo $form->dropDownListControlGroup($presupuesto, 'tarifa_traslado',
                CHtml::listData(TarifaTraslado::model()->findAll(array('condition'=>'activo = 1')), 'id', 'Descripcion'), array('empty' => 'Seleccione','class'=>'span12','multiple'=>true,'onchange'=>"
                if($('#Presupuesto_tarifa_traslado') && $('#Presupuesto_tarifa_traslado').val()){
                    var tarifas =".json_encode($tarifas).";
                    //console.log($('#Presupuesto_tarifa_traslado').val());
                    var ruta = $('#Presupuesto_tarifa_traslado').val();
                    var t = $('#Presupuesto_tipo_tarifa_traslado').val();
                    if($('#idavuelta').is(':checked') || ".$tiv."){
                        t =parseInt(t)+4;
                    }
                    $('#header_tarifa_traslado').text('Monto Traslado: ');
                    var list = '';
                    $.each(ruta,function(index,data){
                        if(tarifas[data][t] == null){
                            $('#tarifa_traslado').html(list);
                        }
                        console.log(tarifas[data][t]);
                        if(tarifas[data][t] != null){
                            list = list + '<li>'+tarifas[data][t]+'</li>';
                            $('#tarifa_traslado').html(list);
                        }
                    });
                }",)); ?>

        </div>
         <div class="span3">
            <?php echo $form->dropDownListControlGroup($presupuesto, 'tipo_tarifa_traslado',
                array('1'=>'Camioneta, 3,5Mts3','2'=>'Camión ¾, 6,5Mts3','3'=>'Camión, 30Mts3','4'=>'Carro ffvv terreno'), array('onchange'=>"
                if($('#Presupuesto_tarifa_traslado') && $('#Presupuesto_tarifa_traslado').val()){
                    var tarifas =".json_encode($tarifas).";
                    var ruta = $('#Presupuesto_tarifa_traslado').val();
                    var t = $('#Presupuesto_tipo_tarifa_traslado').val();
                    if($('#idavuelta').is(':checked') || ".$tiv."){
                        t =parseInt(t)+4;
                    }
                    $('#header_tarifa_traslado').text('Monto Traslado: ');
                    var list = '';
                    $.each(ruta,function(index, data){
                        if(tarifas[data][t] == null){
                            $('#tarifa_traslado').html(list);
                        }
                        console.log(tarifas[data][t]);
                        if(tarifas[data][t] != null){
                            list = list + '<li>'+tarifas[data][t]+'</li>';
                            $('#tarifa_traslado').html(list);
                        }
                    });
                }",)); ?>
        </div>
    </div>
</div>
<div class="row">
    <?php echo $form->textAreaControlGroup($presupuesto,'nota',array('rows'=>6,'span'=>8)); ?>
</div>
<div class="row">
    <h3 id="header_tarifa_traslado"></h3>
    <ul id="tarifa_traslado">
        
    </ul>
</div>
        
       
        
