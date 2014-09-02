<?php
/* @var $this DistribuidorController */
/* @var $model Distribuidor */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Distribuidor')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Distribuidor.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Distribuidor.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Distribuidor.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Distribuidor.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Distribuidor.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Distribuidor.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>