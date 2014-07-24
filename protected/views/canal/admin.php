<?php
/* @var $this CanalController */
/* @var $model Canal */


$this->breadcrumbs=array(
	Yii::t('app','model.Canal')
=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Canal.create'),'url'=>array('create')),
);
?>

<h1><?php echo Yii::t('app','model.Canal.admin'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'canal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>