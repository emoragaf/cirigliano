<?php
/* @var $this PresupuestoController */
/* @var $model Presupuesto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Presupuesto')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Presupuesto.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Presupuesto.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Presupuesto.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Presupuesto.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>