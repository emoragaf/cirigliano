<?php
/* @var $this MuebleController */
/* @var $model Mueble */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Mueble')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Mueble.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Mueble.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Mueble.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Mueble.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Mueble.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>