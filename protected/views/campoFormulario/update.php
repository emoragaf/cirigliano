<?php
/* @var $this CampoFormularioController */
/* @var $model CampoFormulario */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Campo Formulario')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.CampoFormulario.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.CampoFormulario.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.CampoFormulario.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.CampoFormulario.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.CampoFormulario.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>