<?php
/* @var $this AdicionalController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Adicional')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Adicional.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Adicional.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Adicional')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>