<?php
/* @var $this PuntoController */
/* @var $model Punto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Punto')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Punto')),
	array('label'=>Yii::t('app','model.Punto.admin'),'url'=>array('admin')),
	array('label'=>Yii::t('app','model.Punto.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Punto.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Punto.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.MueblePunto')),
	array('label'=>Yii::t('app','model.MueblePunto.create'),'url'=>array('/MueblePunto/create','id'=>$model->id)),
);

$fechaCreacionBetween = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        // 'model'=>$model,
                                    'name' => 'Visita[fecha_creacion_inicio]',
                                    'language' => 'es',
                                        'value' => $visitas->fecha_creacion_inicio,
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
                                        'value' => $visitas->fecha_creacion_final,
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
                                        'value' => $visitas->fecha_visita_inicio,
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
                                        'value' => $visitas->fecha_visita_final,
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

<h1><?php echo Yii::t('app','model.Punto.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'direccion',
		array(
			'name'=>'region_id',
			'value'=>isset($model->region) ? $model->region->nombre : null,
			),
		array(
			'name'=>'comuna_id',
			'value'=>isset($model->comuna) ? $model->comuna->nombre : null,
			),
		array(
			'name'=>'distribuidor_id',
			'value'=>isset($model->distribuidor) ? $model->distribuidor->nombre : null,
			),
		array(
			'name'=>'canal_id',
			'value'=>isset($model->canal) ? $model->canal->nombre : null,
			),
	),
)); ?>
<h3><?php echo Yii::t('app','model.Visita');?></h3>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'visita-grid',
	'dataProvider'=>$visitas->searchVisitasPunto($model->id),
	'afterAjaxUpdate'=>"function() {
                                                jQuery('#Visita_fecha_creacion_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_creacion_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_visita_inicio').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                jQuery('#Visita_fecha_visita_final').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['es'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                                }",
	'filter'=>$visitas,
	'columns'=>array(
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
				'name'=>'tipo_visita_id',
				'value'=>'$data->tipoVisita->nombre',
				'filter'=>CHtml::listData(TipoVisita::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'estado',
				'value'=>'$data->nombreEstado',
				'filter'=>Visita::model()->Estados,
				),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
			),
	),
)); ?>

<h3><?php echo Yii::t('app','model.MueblePunto');?></h3>
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$muebles,
	'itemView'=>'_viewMuebles',
)); ?>