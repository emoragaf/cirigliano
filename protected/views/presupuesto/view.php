<?php
/* @var $this PresupuestoController */
/* @var $model Presupuesto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Presupuesto')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Presupuesto.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Presupuesto.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Presupuesto.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Presupuesto.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Presupuesto.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'total',
		'nota',
		'visita_id',
		'user_id',
		'estado',
		'fecha_creacion',
		'fecha_respuesta',
		'fecha_asignacion',
		'fecha_termino',
	),
)); ?>