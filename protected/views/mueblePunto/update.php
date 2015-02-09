<?php
/* @var $this MueblePuntoController */
/* @var $model MueblePunto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Mueble Punto')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	//array('label'=>Yii::t('app','model.MueblePunto.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.MueblePunto.create'),'url'=>array('create','id'=>$model->punto_id)),
	array('label'=>Yii::t('app','model.MueblePunto.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.MueblePunto.admin'),'url'=>array('admin','id'=>$model->punto_id)),
);
?>

<h1> <?php echo Yii::t('app','model.MueblePunto.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>