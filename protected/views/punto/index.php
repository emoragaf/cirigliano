<?php
/* @var $this PuntoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Punto')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Punto.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Punto.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Punto')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>