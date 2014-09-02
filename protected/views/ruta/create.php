<?php
/* @var $this RutaController */
/* @var $model Ruta */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Ruta')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Ruta.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Ruta.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Ruta.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>