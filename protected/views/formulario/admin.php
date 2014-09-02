<?php
/* @var $this FormularioController */
/* @var $model Formulario */


$this->breadcrumbs=array(
	'Yii::t('app','model.Formulario')
'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Formulario.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Formulario.create'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#formulario-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app','model.Formulario.admin'); ?></h1>

<?php echo CHtml::link(Yii::t('app','Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'formulario-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'notas',
		'visita_id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>