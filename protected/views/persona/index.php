<?php
/* @var $this PersonaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Persona')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Persona.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Persona.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Persona')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>