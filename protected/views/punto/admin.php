<?php
/* @var $this PuntoController */
/* @var $model Punto */


$this->breadcrumbs=array(
	Yii::t('app','model.Punto')=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Punto.create'),'url'=>array('create')),
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
	'filter'=>$model,
	'columns'=>array(
		'direccion',
		array(
				'name'=>'region_id',
				'value'=>'isset($data->region) ? $data->region->nombre : null',
				'filter'=>CHtml::listData(Region::model()->findAll(array('order'=>'orden')), 'id', 'nombre'),
				),
		array(
				'name'=>'comuna_id',
				'value'=>'isset($data->comuna) ? $data->comuna->nombre : null',
				'filter'=>CHtml::listData(Comuna::model()->findAll(), 'id', 'nombre'),
				),
		array(
				'name'=>'canal_id',
				'value'=>'isset($data->canal) ? $data->canal->nombre : null',
				'filter'=>CHtml::listData(Canal::model()->findAll(), 'id', 'nombre'),
				),
		array(
				'name'=>'distribuidor_id',
				'value'=>'isset($data->distribuidor) ? $data->distribuidor->nombre : null',
				'filter'=>CHtml::listData(Distribuidor::model()->findAll(), 'id', 'nombre'),
				),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>