<?php
/* @var $this CanalController */
/* @var $model Canal */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Canal')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Canal.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Canal.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Canal.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>