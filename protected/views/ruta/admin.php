<?php
/* @var $this RutaController */
/* @var $model Ruta */


$this->breadcrumbs=array(
	Yii::t('app','model.Ruta')
=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>Yii::t('app','model.Ruta.index'),'url'=>array('index')),
	//array('label'=>Yii::t('app','model.Ruta.create'),'url'=>array('create')),
);
?>

<h1><?php echo Yii::t('app','model.Ruta.admin'); ?></h1>


<?php 
setlocale(LC_TIME, 'es_ES');

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ruta-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' =>'tipo_ruta_id',
			'value'=>'$data->tiporuta->nombre',
			'filter'=>Chtml::listData(TipoRuta::model()->findAll(),'id','nombre'),
		),
		array(
			'name'=>'mes',
			'value'=>'strftime("%B %Y",strtotime($data->mes))',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>