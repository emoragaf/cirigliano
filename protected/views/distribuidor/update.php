<?php
/* @var $this DistribuidorController */
/* @var $model Distribuidor */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Distribuidor')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Distribuidor.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Distribuidor.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Distribuidor.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>