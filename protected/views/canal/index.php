<?php
/* @var $this CanalController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Canal')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Canal.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Canal.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Canal')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>