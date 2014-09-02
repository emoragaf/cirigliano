<?php
/* @var $this DistribuidorController */
/* @var $model Distribuidor */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Distribuidor')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Distribuidor.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Distribuidor.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>