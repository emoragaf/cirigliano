<?php
/* @var $this VisitaController */
/* @var $model Visita */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Visita')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Visita.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Visita.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Visita.view'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Visita.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Visita.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>