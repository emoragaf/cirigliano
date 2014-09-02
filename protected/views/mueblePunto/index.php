<?php
/* @var $this MueblePuntoController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Mueble Punto')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.MueblePunto.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.MueblePunto.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Mueble Punto')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>