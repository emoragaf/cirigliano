<?php
/* @var $this VisitaController */
/* @var $model Visita */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Visita')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Visita.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Visita.admin'),'url'=>array('admin')),
);
?>
<h1> <?php echo $model->tipo_visita_id == 3?Yii::t('app','model.Visita.createTraslado'):Yii::t('app','model.Visita.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>