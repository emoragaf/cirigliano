<?php
/* @var $this ComunaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Comuna')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Comuna.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Comuna.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Comuna')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>