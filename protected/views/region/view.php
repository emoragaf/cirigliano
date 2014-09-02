<?php
/* @var $this RegionController */
/* @var $model Region */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Region')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Region.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Region.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Region.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Region.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Region.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Region.view');?></h1>

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