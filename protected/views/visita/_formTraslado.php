<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form TbActiveForm */
$tarifas = array();
foreach(Tarifatraslado::model()->findAll(array('condition'=>'activo=1')) as $tarifa){
    $tarifas[$tarifa->id] = array('1'=>$tarifa->tarifa_a,'2'=>$tarifa->tarifa_b,'3'=>$tarifa->tarifa_c,'4'=>$tarifa->tarifa_d);
}
?>
    <!--<p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>-->
<?php //print_r(json_encode($tarifas)) ?>
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
<div class="row">
        <div class="span3">
            <label>Punto Destino</label>
            <?php 
                $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                    'model' => $model,
                    'attribute'=>'destino_traslado_id',
                    'data' => array(''=>'Seleccione') + CHtml::listData(Punto::model()->findAll(array('order'=>'direccion')), 'id', 'Descripcion'),
                    'pluginOptions' => array(
                        'placeholder' => 'Destino',
                        'allowClear' => true,
                        'width' => '100%'
                    )
                    ));
            ?>
        </div>

    <div class="span3">
         <?php echo $form->dropDownListControlGroup($presupuesto, 'tarifa_traslado',
            CHtml::listData(TarifaTraslado::model()->findAll(array('condition'=>'activo = 1')), 'id', 'Descripcion'), array('empty' => 'Seleccione','onchange'=>"
            if($('#Presupuesto_tarifa_traslado') && $('#Presupuesto_tarifa_traslado').val()){
                var tarifas =".json_encode($tarifas).";
                var ruta = $('#Presupuesto_tarifa_traslado').val();
                var t = $('#Presupuesto_tipo_tarifa_traslado').val();
                $('#tarifa_traslado').text('Monto Traslado: '+tarifas[ruta][t]);
            }",)); ?>

    </div>
     <div class="span3">
        <?php echo $form->dropDownListControlGroup($presupuesto, 'tipo_tarifa_traslado',
            array('1'=>'Camioneta, 3,5Mts3','2'=>'Camión ¾, 6,5Mts3','3'=>'Camión, 30Mts3','4'=>'Carro ffvv terreno'), array('onchange'=>"
            if($('#Presupuesto_tarifa_traslado') && $('#Presupuesto_tarifa_traslado').val()){
                var tarifas =".json_encode($tarifas).";
                var ruta = $('#Presupuesto_tarifa_traslado').val();
                var t = $('#Presupuesto_tipo_tarifa_traslado').val();
                $('#tarifa_traslado').text('Monto Traslado: '+tarifas[ruta][t]);
            }",)); ?>
    </div>
</div>
<div class="row">
    <?php echo $form->textAreaControlGroup($presupuesto,'nota',array('rows'=>6,'span'=>8)); ?>
</div>
<div class="row">
    <h3 id="tarifa_traslado"></h3>
</div>
        
       
        
