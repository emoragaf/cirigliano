<?php
/* @var $this MuebleController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Mueble')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Mueble.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Mueble.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Mueble')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>