<?php
/* @var $this NotificarPersonaController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Notificar Persona')
,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.NotificarPersona.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.NotificarPersona.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Notificar Persona')
;?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>