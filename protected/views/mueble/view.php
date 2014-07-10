<?php
/* @var $this MuebleController */
/* @var $model Mueble */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Mueble')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Mueble.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Mueble.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Mueble.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Mueble.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Mueble.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Mueble.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'codigo',
		'descripcion',
	),
)); ?>