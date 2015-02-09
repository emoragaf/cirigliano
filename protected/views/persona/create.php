<?php
/* @var $this PersonaController */
/* @var $model Persona */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Persona')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Persona.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Persona.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Persona.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>