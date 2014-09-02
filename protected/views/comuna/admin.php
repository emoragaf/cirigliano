<?php
/* @var $this ComunaController */
/* @var $model Comuna */


$this->breadcrumbs=array(
	Yii::t('app','model.Comuna')
=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Comuna.create'),'url'=>array('create')),
);
?>

<h1><?php echo Yii::t('app','model.Comuna.admin'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'comuna-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'name'=>'region_id',
			'value'=>'$data->region->nombre',
			'filter'=>CHtml::listData(Region::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),

			),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>