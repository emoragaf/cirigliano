<?php
/* @var $this RegionController */
/* @var $model Region */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Region')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Region.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Region.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Region.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Region.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Region.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>