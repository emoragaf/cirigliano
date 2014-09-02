<?php
/* @var $this ComunaController */
/* @var $model Comuna */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Comuna')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Comuna.admin'),'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app','model.Comuna.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>