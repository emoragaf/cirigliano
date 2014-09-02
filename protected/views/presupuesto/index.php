<?php
/* @var $this PresupuestoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Presupuesto')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Presupuesto.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Presupuesto')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>