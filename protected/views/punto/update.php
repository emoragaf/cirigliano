<?php
/* @var $this PuntoController */
/* @var $model Punto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Punto')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Punto.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Punto.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Punto.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Punto.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>