<?php
/* @var $this RegionController */
/* @var $model Region */


$this->breadcrumbs=array(
	'Yii::t('app','model.Region')
'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Region.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Region.create'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#region-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app','model.Region.admin'); ?></h1>

<?php echo CHtml::link(Yii::t('app','Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'region-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>