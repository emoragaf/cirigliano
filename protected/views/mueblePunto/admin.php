<?php
/* @var $this MueblePuntoController */
/* @var $model MueblePunto */


$this->breadcrumbs=array(
	Yii::t('app','model.Mueble Punto')
=>array('index'),
	'Administrar',
);

$this->menu=array(
	//array('label'=>Yii::t('app','model.MueblePunto.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.MueblePunto.create'),'url'=>array('create','id'=>$punto_id)),
);
?>

<h1><?php echo Yii::t('app','model.MueblePunto.admin'); ?></h1>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'mueble-punto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'mueble_id',
			'value'=>'$data->mueble->descripcion',
			'filter'=>CHtml::listData(Mueble::model()->findAll(array('order'=>'descripcion')),'id','descripcion')
		),
		array(
			'name'=>'punto_id',
			'value'=>'$data->punto->direccion',
			'filter'=>'',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>