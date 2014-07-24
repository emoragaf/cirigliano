<?php
/* @var $this CanalController */
/* @var $model Canal */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Canal')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Canal.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Canal.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Canal.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>