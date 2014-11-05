<?php
/* @var $this VisitaController */
/* @var $model Visita */


$this->breadcrumbs=array(
	Yii::t('app','model.Visita')=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Visita.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Visita.create'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#visita-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app','model.Visita.admin'); ?></h1>

<?php echo CHtml::link(Yii::t('app','Busqueda Avanzada'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'visita-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'fecha_creacion',
		'punto_id',
		'tipo_visita_id',
		'persona_punto_id',
		'estado',
		'fecha_visita',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>Yii::app()->user->checkAccess('Visita.update') && Yii::app()->user->checkAccess('Visita.delete') ? '{view}{update}{delete}': '{view}',

		),
	),
)); ?>