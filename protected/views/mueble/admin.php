<?php
/* @var $this MuebleController */
/* @var $model Mueble */


$this->breadcrumbs=array(
	Yii::t('app','model.Mueble')
=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Mueble.create'),'url'=>array('create')),
);

?>

<h1><?php echo Yii::t('app','model.Mueble.admin'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'mueble-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'codigo',
		'descripcion',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>