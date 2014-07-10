<?php
/* @var $this PuntoController */
/* @var $model Punto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Punto')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Punto')),
	array('label'=>Yii::t('app','model.Punto.admin'),'url'=>array('admin')),
	array('label'=>Yii::t('app','model.Punto.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Punto.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Punto.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.MueblePunto')),
	array('label'=>Yii::t('app','model.MueblePunto.create'),'url'=>array('/MueblePunto/create','id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('app','model.Punto.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'direccion',
		array(
			'name'=>'region_id',
			'value'=>$model->region->nombre,
			),
		array(
			'name'=>'canal_id',
			'value'=>$model->canal->nombre,
			),
	),
)); ?>

<h2><?php echo Yii::t('app','model.MueblePunto');?></h2>
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$muebles,
	'itemView'=>'_viewMuebles',
)); ?>