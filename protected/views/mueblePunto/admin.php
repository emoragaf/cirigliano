<?php
/* @var $this MueblePuntoController */
/* @var $model MueblePunto */


$this->breadcrumbs=array(
	'Yii::t('app','model.Mueble Punto')
'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.MueblePunto.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.MueblePunto.create'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#mueble-punto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app','model.MueblePunto.admin'); ?></h1>

<?php echo CHtml::link(Yii::t('app','Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'mueble-punto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'mueble_id',
		'punto_id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>