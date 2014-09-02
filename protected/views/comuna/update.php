<?php
/* @var $this ComunaController */
/* @var $model Comuna */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Comuna')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Comuna.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Comuna.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Comuna.update'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>