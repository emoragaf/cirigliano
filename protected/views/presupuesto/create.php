<?php
/* @var $this PresupuestoController */
/* @var $model Presupuesto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Presupuesto')=>array('index'),
	'Crear',
);
?>
<h1> <?php echo Yii::t('app','model.Presupuesto.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'muebles'=>$muebles)); ?>