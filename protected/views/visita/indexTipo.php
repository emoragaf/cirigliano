<?php
/* @var $this VisitaController */
/* @var $dataProvider CActiveDataProvider */
if($tipo == 1){
    $filtroTipos = CHtml::listData(TipoVisita::model()->findAll(array('condition'=>'id = 1 or id = 2','order'=>'nombre')),'id','nombre');
}
else
    $filtroTipos = array();
$tipos = CHtml::listData(TipoVisita::model()->findAll(array('order'=>'nombre')),'id','nombre');
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#visitaPendiente-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php 
// this is the date picker
$fechaCreacionBetween = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        // 'model'=>$model,
                                    'name' => 'Visita[fecha_creacion_inicio]',
                                    'language' => 'es',
                                        'value' => $model->fecha_creacion_inicio,
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>'dd-mm-yy',
                                        'changeMonth' => 'true',
                                        'changeYear'=>'true',
                                        'constrainInput' => 'false',
                                    ),
                                    'htmlOptions'=>array(
                                        'style'=>'height:20px;width:70px;',
                                    ),
// DONT FORGET TO ADD TRUE this will create the datepicker return as string
                                ),true) . '<br> a <br> ' . $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        // 'model'=>$model,
                                    'name' => 'Visita[fecha_creacion_final]',
                                    'language' => 'es',
                                        'value' => $model->fecha_creacion_final,
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>'dd-mm-yy',
                                        'changeMonth' => 'true',
                                        'changeYear'=>'true',
                                        'constrainInput' => 'false',
                                    ),
                                    'htmlOptions'=>array(
                                        'style'=>'height:20px;width:70px',
                                    ),
// DONT FORGET TO ADD TRUE this will create the datepicker return as string
                                ),true);

$fechaVisitaBetween = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        // 'model'=>$model,
                                    'name' => 'Visita[fecha_visita_inicio]',
                                    'language' => 'es',
                                        'value' => $model->fecha_visita_inicio,
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>'dd-mm-yy',
                                        'changeMonth' => 'true',
                                        'changeYear'=>'true',
                                        'constrainInput' => 'false',
                                    ),
                                    'htmlOptions'=>array(
                                        'style'=>'height:20px;width:70px;',
                                    ),
// DONT FORGET TO ADD TRUE this will create the datepicker return as string
                                ),true) . '<br> a <br> ' . $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        // 'model'=>$model,
                                    'name' => 'Visita[fecha_visita_final]',
                                    'language' => 'es',
                                        'value' => $model->fecha_visita_final,
                                    // additional javascript options for the date picker plugin
                                    'options'=>array(
                                        'showAnim'=>'fold',
                                        'dateFormat'=>'dd-mm-yy',
                                        'changeMonth' => 'true',
                                        'changeYear'=>'true',
                                        'constrainInput' => 'false',
                                    ),
                                    'htmlOptions'=>array(
                                        'style'=>'height:20px;width:70px',
                                    ),
// DONT FORGET TO ADD TRUE this will create the datepicker return as string
                                ),true);

?>

<div class="container-fluid">

   <div class="row span12">
        <div class="search-form">
        <?php /*$this->renderPartial('_search',array(
            'model'=>$model,
            'tipo'=>$tipo,
        ));*/ ?>
        </div><!-- search-form -->
   </div>
	<h1><?php echo $tipo ==1 ? 'Incidencias' : $tipos[$tipo]
	;?></h1>

	<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'visitaPendiente-grid',
		'type'=>'bordered',
        'filterPosition'=>'header',
		'dataProvider'=>$model->searchRelations(array('tipo'=>$tipo)),
		'afterAjaxUpdate'=>"function() {
                                                jQuery('#Visita_punto_comuna_id').select2({'width':'100%'}); jQuery('#Visita_punto_distribuidor_id').select2({'width':'100%'});
                                                jQuery('#Visita_fecha_creacion_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_creacion_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_visita_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_visita_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                }",
		'filter'=>$model,
		'columns'=>array(
            array(
                'name'=>'folio',
                //'filter'=>false,
                ),
			array(
                'header'=>$tipo == 3 ? 'Origen': 'Dirección',
				'name'=>'punto_direccion',
				'value'=>'$data->punto->direccion',
                //'filter'=>false,
				),
            array(
                'name'=>'punto_codigo',
                'value'=>'isset($data->punto->codigo)?$data->punto->codigo:"N/A"',
                //'filter'=>false,
                ),
            array(
                'name'=>'punto_destino',
                'value'=>'$data->destino != null ? $data->destino->Descripcion : null',
                'visible'=>$tipo == 3 ? true: false,
                'filter'=>false,
                ),
			array(
				'name'=>'fecha_creacion',
				'filter'=>$fechaCreacionBetween,
				'value'=>'date("d-m-Y",strtotime($data->fecha_creacion))',
                //'filter'=>false,
				),
			array(
				'name'=>'fecha_visita',
				'filter'=>$fechaVisitaBetween,
                //'filter'=>false,
				'value'=>'$data->fecha_visita !== null ? date("d-m-Y",strtotime($data->fecha_visita)) : null'
				),
			array(
				'name'=>'punto_canal_id',
				'value'=>'isset($data->punto->canal) ? $data->punto->canal->nombre: null',
				'filter'=>CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				//'filter'=>false,
                ),
			array(
				'name'=>'punto_distribuidor_id',
				'value'=>'isset($data->punto->distribuidor) ? $data->punto->distribuidor->nombre: null',
                'filter'=>false,
				'filter'=>$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                    'model' => $model,
                    'attribute'=>'punto_distribuidor_id',
                    'data' => array(''=>'',0=>'Todos') + CHtml::listData(Distribuidor::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
                    'pluginOptions' => array(
                        'placeholder' => 'Distribuidor',
                        'allowClear' => true,
                        'width' => '100%'
                    )
                    ),true),
				),
			array(
				'name'=>'punto_region_id',
				'value'=>'isset($data->punto->region) ? $data->punto->region->nombre : null',
				'filter'=>CHtml::listData(Region::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				//'filter'=>false,
                ),
			array(
				'name'=>'punto_comuna_id',
				'value'=>'isset($data->punto->comuna) ? $data->punto->comuna->nombre :null',
				'filter'=>$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                    'model' => $model,
                    'attribute'=>'punto_comuna_id',
                    'data' => array(''=>'',0=>'Todos') + CHtml::listData(Comuna::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
                    'pluginOptions' => array(
                        'placeholder' => 'Comuna',
                        'allowClear' => true,
                        'width' => '100%'
                    )
                    ),true),
                //'filter'=>false,
                ),
			array(
				'name'=>'tipo_visita_id',
				'value'=>'$data->tipoVisita->nombre',
				'filter'=>$filtroTipos,
                //'filter'=>false,
                'visible'=> $tipo == 1? true : false,
				),
			array(
				'name'=>'estado',
				'value'=>'$data->nombreEstado',
				'filter'=>$model->Estados,
                //'filter'=>false,
				),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
                'template'=>Yii::app()->user->checkAccess('Visita.update') && Yii::app()->user->checkAccess('Visita.delete') ? '{view}{update}{delete}': '{view}',
                'buttons'=>array(
                    'view'=>array(
                        'options'=>array('target'=>'none'),
                    ),
                    'update'=>array(
                        'options'=>array('target'=>'none'),
                    ),
                ),
			),
		),
	)); ?>

	
</div>