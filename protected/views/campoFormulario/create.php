<?php
/* @var $this CampoFormularioController */
/* @var $model CampoFormulario */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Campo Formulario')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.CampoFormulario.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.CampoFormulario.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.CampoFormulario.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>