<?php
/* @var $this VisitaController */
/* @var $model Visita */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Visita')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Visita.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Visita.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Visita.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Visita.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Visita.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Visita.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'organizacion_id',
		'visitador_id',
		'visitado_id',
		'fecha_programada',
		'fecha_realizada',
		'notas',
	),
)); ?>