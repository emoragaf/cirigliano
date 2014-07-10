<?php
/* @var $this MueblePuntoController */
/* @var $model MueblePunto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Mueble Punto')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.MueblePunto.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.MueblePunto.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.MueblePunto.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>