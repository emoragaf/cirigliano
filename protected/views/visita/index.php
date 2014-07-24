<?php
/* @var $this VisitaController */
/* @var $dataProvider CActiveDataProvider */
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
$fechaCreacionBetweenActivo = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        // 'model'=>$model,
                                    'name' => 'Visita[fecha_creacion_inicio]',
                                    'id'=>'VisitaActivo_fecha_creacion_inicio',
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
                                    'id'=>'VisitaActivo_fecha_creacion_final',
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
$fechaVisitaBetweenActivo = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        // 'model'=>$model,
                                    'name' => 'Visita[fecha_visita_inicio]',
                                    'id'=>'VisitaActivo_fecha_visita_inicio',
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
                                    'id'=>'VisitaActivo_fecha_visita_final',
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

	<h1><?php echo Yii::t('app','model.Visita')
	;?></h1>


	<h3>Pendientes</h3>
	<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'visitaPendiente-grid',
		'type'=>'bordered',
		'dataProvider'=>$model->searchRelationsPendientes(),
		'afterAjaxUpdate'=>"function() {
                                                jQuery('#Visita_fecha_creacion_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_creacion_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_visita_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_visita_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                }",
		'filter'=>$model,
		'columns'=>array(
			array(
				'name'=>'punto_direccion',
				'value'=>'$data->punto->direccion'
				),
			array(
				'name'=>'fecha_creacion',
				'filter'=>$fechaCreacionBetween,
				'value'=>'date("d-m-Y",strtotime($data->fecha_creacion))'
				),
			array(
				'name'=>'fecha_visita',
				'filter'=>$fechaVisitaBetween,
				'value'=>'$data->fecha_visita !== null ? date("d-m-Y",strtotime($data->fecha_visita)) : null'
				),
			array(
				'name'=>'punto_canal_id',
				'value'=>'isset($data->punto->canal) ? $data->punto->canal->nombre: null',
				'filter'=>CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'punto_distribuidor_id',
				'value'=>'isset($data->punto->distribuidor) ? $data->punto->distribuidor->nombre: null',
				'filter'=>CHtml::listData(Distribuidor::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'punto_region_id',
				'value'=>'isset($data->punto->region) ? $data->punto->region->nombre : null',
				'filter'=>CHtml::listData(Region::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'punto_comuna_id',
				'value'=>'isset($data->punto->comuna) ? $data->punto->comuna->nombre :null',
				'filter'=>CHtml::listData(Comuna::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'tipo_visita_id',
				'value'=>'$data->tipoVisita->nombre',
				'filter'=>CHtml::listData(TipoVisita::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'estado',
				'value'=>'$data->nombreEstado',
				'filter'=>$model->EstadosPendientes,
				),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
			),
		),
	)); ?>

	<h3>En ejecución</h3>
	<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'visitaActivo-grid',
		'type'=>'bordered',
		'dataProvider'=>$activos->searchRelationsActivos(),
		'afterAjaxUpdate'=>"function() {
                                                jQuery('#VisitaActivo_fecha_creacion_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#VisitaActivo_fecha_creacion_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#VisitaActivo_fecha_visita_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#VisitaActivo_fecha_visita_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                }",
		'filter'=>$activos,
		'columns'=>array(
			array(
				'name'=>'punto_direccion',
				'value'=>'$data->punto->direccion'
				),
			array(
				'name'=>'fecha_creacion',
				'filter'=>$fechaCreacionBetweenActivo,
				'value'=>'date("d-m-Y",strtotime($data->fecha_creacion))'
				),
			array(
				'name'=>'fecha_visita',
				'filter'=>$fechaVisitaBetweenActivo,
				'value'=>'$data->fecha_visita !== null ? date("d-m-Y",strtotime($data->fecha_visita)) : null'
				),
			array(
				'name'=>'punto_canal_id',
				'value'=>'isset($data->punto->canal) ? $data->punto->canal->nombre: null',
				'filter'=>CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'punto_distribuidor_id',
				'value'=>'isset($data->punto->distribuidor) ? $data->punto->distribuidor->nombre: null',
				'filter'=>CHtml::listData(Distribuidor::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'punto_region_id',
				'value'=>'isset($data->punto->region) ? $data->punto->region->nombre : null',
				'filter'=>CHtml::listData(Region::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'punto_comuna_id',
				'value'=>'isset($data->punto->comuna) ? $data->punto->comuna->nombre :null',
				'filter'=>CHtml::listData(Comuna::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'tipo_visita_id',
				'value'=>'$data->tipoVisita->nombre',
				'filter'=>CHtml::listData(TipoVisita::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'estado',
				'value'=>'$data->nombreEstado',
				'filter'=>$model->EstadosPendientes,
				),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
			),
		),
	)); ?>

	
</div>