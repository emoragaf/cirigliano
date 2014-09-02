<?php
/* @var $this DistribuidorController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Distribuidor')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Distribuidor.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Distribuidor.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Distribuidor')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>