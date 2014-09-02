<?php
/* @var $this RutaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Ruta')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Ruta.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Ruta.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Ruta')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>