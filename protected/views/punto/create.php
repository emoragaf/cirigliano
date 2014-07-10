<?php
/* @var $this PuntoController */
/* @var $model Punto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Punto')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Punto.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Punto.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>