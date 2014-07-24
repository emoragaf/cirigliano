<?php
/* @var $this ServicioMuebleController */
/* @var $model ServicioMueble */


$this->breadcrumbs=array(
	Yii::t('app','model.Servicio Mueble')
=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.ServicioMueble.create'),'url'=>array('create')),
);
?>

<h1><?php echo Yii::t('app','model.ServicioMueble.admin'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'servicio-mueble-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'mueble_id',
			'value'=>'$data->mueble->descripcion',
			'filter'=>Chtml::listData(Mueble::model()->findAll(),'id','descripcion'),
		),
		'descripcion',
		'tarifa',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?>