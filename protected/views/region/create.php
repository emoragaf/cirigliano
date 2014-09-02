<?php
/* @var $this RegionController */
/* @var $model Region */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Region')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Region.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Region.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Region.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>