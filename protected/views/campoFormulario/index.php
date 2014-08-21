<?php
/* @var $this CampoFormularioController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.CampoFormulario')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.CampoFormulario.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.CampoFormulario.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.CampoFormulario')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>