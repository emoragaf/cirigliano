<?php
/* @var $this PresupuestoController */
/* @var $model Presupuesto */


$this->breadcrumbs=array(
	'Yii::t('app','model.Presupuesto')
'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Presupuesto.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#presupuesto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app','model.Presupuesto.admin'); ?></h1>

<?php echo CHtml::link(Yii::t('app','Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'presupuesto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'total',
		'nota',
		'visita_id',
		'user_id',
		'estado',
		/*
		'fecha_creacion',
		'fecha_respuesta',
		'fecha_asignacion',
		'fecha_termino',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>