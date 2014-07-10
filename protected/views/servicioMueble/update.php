<?php
/* @var $this ServicioMuebleController */
/* @var $model ServicioMueble */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Servicio Mueble')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.ServicioMueble.create'),'url'=>array('create','id'=>$model->mueble_id)),
	array('label'=>Yii::t('app','model.ServicioMueble.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.ServicioMueble.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.ServicioMueble.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>