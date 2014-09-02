<?php
/* @var $this DistribuidorController */
/* @var $model Distribuidor */


$this->breadcrumbs=array(
	Yii::t('app','model.Distribuidor')
=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Distribuidor.create'),'url'=>array('create')),
);

?>

<h1><?php echo Yii::t('app','model.Distribuidor.admin'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'distribuidor-grid',
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