<?php
/* @var $this FormularioController */
/* @var $model Formulario */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Formulario')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Formulario.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Formulario.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Formulario.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Formulario.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Formulario.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>