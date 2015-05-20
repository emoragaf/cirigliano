<?php
/* @var $this PuntoController */
/* @var $model Punto */


$this->breadcrumbs=array(
	Yii::t('app','model.Punto')=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Punto.create'),'url'=>array('create'),'visible'=>Yii::app()->user->checkAccess('Punto.create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#punto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app','model.Punto.admin'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'punto-grid',
	'type'=>'bordered striped',
	'dataProvider'=>$model->search(),
	'afterAjaxUpdate'=>"function(id,data){jQuery('#Punto_comuna_id').select2({'width':'100%'}); jQuery('#Punto_distribuidor_id').select2({'width':'100%'});}",
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'direccion',
			'value'=>'$data->Direccion',
			),
		array(
                'name'=>'descripcion',
                'value'=>'$data->descripcion',
                //'filter'=>false,
                ),
		array(
				'name'=>'codigo',
				'value'=>'isset($data->codigo) ? $data->codigo : "N/A"',
			),
		array(
				'name'=>'region_id',
				'value'=>'isset($data->region) ? $data->region->nombre : null',
				'filter'=>CHtml::listData(Region::model()->findAll(array('order'=>'orden')), 'id', 'nombre'),
				),
		array(
				'name'=>'comuna_id',
				'value'=>'isset($data->comuna) ? $data->comuna->nombre : null',
				'filter'=>$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
					'model' => $model,
					'attribute'=>'comuna_id',
					'data' => array(''=>'',0=>'Todos') + CHtml::listData(Comuna::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
					'pluginOptions' => array(
			            'placeholder' => 'Comuna',
			            'allowClear' => true,
			            'width' => '100%'
		        	)
					),true),
				),
		array(
				'name'=>'canal_id',
				'value'=>'isset($data->canal) ? $data->canal->nombre : null',
				'filter'=>CHtml::listData(Canal::model()->findAll(), 'id', 'nombre'),
				),
		array(
				'name'=>'subcanal_id',
				'value'=>'isset($data->subcanal) ? $data->subcanal->nombre : null',
				'filter'=>CHtml::listData(Subcanal::model()->findAll(), 'id', 'nombre'),
				),
		array(
				'name'=>'distribuidor_id',
				'value'=>'isset($data->distribuidor) ? $data->distribuidor->nombre : null',
				'filter'=>$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
					'model' => $model,
					'attribute'=>'distribuidor_id',
					'data' => array(''=>'',0=>'Todos') + CHtml::listData(Distribuidor::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
					'pluginOptions' => array(
			            'placeholder' => 'Distribuidor',
			            'allowClear' => true,
			            'width' => '100%'
		        	)
				),true),
				),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>Yii::app()->user->checkAccess('Punto.update') && Yii::app()->user->checkAccess('Punto.delete') ? '{view}{update}{delete}': '{view}',
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