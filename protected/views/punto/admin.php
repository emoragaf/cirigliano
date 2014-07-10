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

<!--<?php echo CHtml::link(Yii::t('app','Búsqueda Avanzada'),'#',array('class'=>'search-button btn')); ?>-->
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>



<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'punto-grid',
	'type'=>'bordered striped',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'direccion',
		array(
				'name'=>'region_id',
				'value'=>'$data->region->nombre',
				'filter'=>CHtml::listData(Region::model()->findAll(array('order'=>'orden')), 'id', 'nombre'),
				),
		array(
				'name'=>'canal_id',
				'value'=>'$data->canal->nombre',
				'filter'=>CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>