<?php
/* @var $this VisitaController */
/* @var $dataProvider CActiveDataProvider */
?>
<?php 
// this is the date picker
$fechaCreacionBetween = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        // 'model'=>$model,
                                    'name' => 'Reparacion[fecha_creacion_inicio]',
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
                                    'name' => 'Reparacion[fecha_creacion_final]',
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
                                    'name' => 'Reparacion[fecha_visita_inicio]',
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
                                    'name' => 'Reparacion[fecha_visita_final]',
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

	<h1>Histórico Reparaciones</h1>

	<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'visitaPendiente-grid',
		'type'=>'bordered',
		'dataProvider'=>$model->searchRelations(),
		'afterAjaxUpdate'=>"function() {
                                                jQuery('#Reparacion_fecha_creacion_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Reparacion_fecha_creacion_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Reparacion_fecha_visita_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Reparacion_fecha_visita_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                }",
		'filter'=>$model,
		'columns'=>array(
			array(
				'name'=>'punto_direccion',
				'value'=>'$data->idPunto!= null ? $data->idPunto->direccion: null'
				),
			array(
				'name'=>'fecha_ingreso',
				'filter'=>$fechaCreacionBetween,
				'value'=>'$data->fecha_ingreso !== null ? date("d-m-Y",strtotime($data->fecha_ingreso)) : null'
				),
			array(
				'name'=>'fecha_ejecucion',
				'filter'=>$fechaVisitaBetween,
				'value'=>'$data->fecha_ejecucion !== null ? date("d-m-Y",strtotime($data->fecha_ejecucion)) : null'
				),
			array(
				'name'=>'punto_canal_id',
				'value'=>'isset($data->idPunto->idCanal) ? $data->idPunto->idCanal->descripcion: null',
				'filter'=>CHtml::listData(Canal::model()->findAll(array('order'=>'descripcion')), 'id', 'descripcion'),
				),
			array(
				'name'=>'punto_distribuidor_id',
				'value'=>'isset($data->idPunto->idDistribuidor) ? $data->idPunto->idDistribuidor->descripcion: null',
				'filter'=>CHtml::listData(Distribuidor::model()->findAll(array('order'=>'descripcion')), 'id', 'descripcion'),
				),
			array(
				'name'=>'punto_comuna_id',
				'value'=>'isset($data->idPunto->idComuna) ? $data->idPunto->idComuna->nombre: null',
				'filter'=>CHtml::listData(Comuna::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'observaciones',
				),
			array(
				'name'=>'id_estado_reparacion',
				'value'=>'$data->idEstadoReparacion != null ? $data->idEstadoReparacion->descripcion: null',
				'filter'=>CHtml::listData(EstadoReparacion::model()->findAll(array('order'=>'descripcion')), 'id_estado_reparacion', 'descripcion'),
				),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{view}',
                'buttons'=>array(
                    'view'=>array('options'=>array('target'=>'none')),
                ),
			),
		),
	)); ?>

	
</div>