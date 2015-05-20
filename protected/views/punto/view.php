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
	array('label'=>Yii::t('app','model.Punto.admin'),'url'=>array('admin'),'visible'=>Yii::app()->user->checkAccess('Punto.admin')),
	array('label'=>Yii::t('app','model.Punto.create'),'url'=>array('create'),'visible'=>Yii::app()->user->checkAccess('Punto.create')),
	array('label'=>Yii::t('app','model.Punto.update'),'url'=>array('update','id'=>$model->id),'visible'=>Yii::app()->user->checkAccess('Punto.update')),
	array('label'=>Yii::t('app','model.Punto.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>Yii::app()->user->checkAccess('Punto.delete')),
	array('label'=>Yii::t('app','model.MueblePunto'),'visible'=>Yii::app()->user->checkAccess('MueblePunto.create')),
	array('label'=>Yii::t('app','model.MueblePunto.create'),'url'=>array('/MueblePunto/create','id'=>$model->id),'visible'=>Yii::app()->user->checkAccess('MueblePunto.create')),
    array('label'=>Yii::t('app','model.Visita'),'visible'=>Yii::app()->user->checkAccess('Visita.crear')),
    array('label'=>Yii::t('app','model.Visita.create'),'url'=>array('/Visita/crear','id'=>$model->id),'visible'=>Yii::app()->user->checkAccess('Visita.crear')),
    array('label'=>Yii::t('app','model.Visita.createTraslado'),'url'=>array('/Visita/createTraslado','id'=>$model->id),'visible'=>Yii::app()->user->checkAccess('Visita.crearTraslado')),
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
        array(
            'name'=>'subcanal_id',
            'value'=>isset($model->subcanal) ? $model->subcanal->nombre : null,
            ),
	),
)); ?>

<h2><?php echo Yii::t('app','model.Visita'); ?></h2>

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
        'folio',
            array(
                'name'=>'codigo',
                'value'=>'$data->codigo?$data->codigo:"N/A"',
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
                'template'=>Yii::app()->user->checkAccess('Visita.update') && Yii::app()->user->checkAccess('Visita.delete') ? '{view}{update}{delete}': '{view}',
                'buttons'=>array(
                    'view' => array
                    (
                        'url'=>'Yii::app()->createUrl("Visita/View", array("id"=>$data->id))',
                    ),
                    'update' => array
                    (
                        'url'=>'Yii::app()->createUrl("Visita/Update", array("id"=>$data->id))',
                    ),
                    'delete' => array
                    (
                        'url'=>'Yii::app()->createUrl("Visita/Delete", array("id"=>$data->id))',
                    ),
                ),
			),
	),
)); ?>

<h2><?php echo Yii::t('app','model.MueblePunto');?></h2>
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$muebles,
	'itemView'=>'_viewMuebles',
)); ?>