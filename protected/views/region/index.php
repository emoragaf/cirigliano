<?php
/* @var $this RegionController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Region')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Region.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Region.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Region')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>