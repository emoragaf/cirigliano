<?php
/* @var $this MuebleController */
/* @var $model Mueble */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Mueble')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Mueble.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Mueble.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>