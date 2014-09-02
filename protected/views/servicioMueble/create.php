<?php
/* @var $this ServicioMuebleController */
/* @var $model ServicioMueble */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Servicio Mueble')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.ServicioMueble.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.ServicioMueble.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>