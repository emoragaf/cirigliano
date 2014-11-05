<?php
/* @var $this NotificarPersonaController */
/* @var $model NotificarPersona */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Notificar Persona')=>array('index'),
	'Crear',
);

$this->menu=array(
	//array('label'=>Yii::t('app','model.NotificarPersona.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.NotificarPersona.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.NotificarPersona.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'persona'=>$persona)); ?>