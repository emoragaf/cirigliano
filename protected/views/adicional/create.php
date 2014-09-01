<?php
/* @var $this AdicionalController */
/* @var $model Adicional */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Adicional')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Adicional.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Adicional.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Adicional.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>