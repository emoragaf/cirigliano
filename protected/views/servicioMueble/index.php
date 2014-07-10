<?php
/* @var $this ServicioMuebleController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Servicio Mueble')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.ServicioMueble.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.ServicioMueble.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Servicio Mueble')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>