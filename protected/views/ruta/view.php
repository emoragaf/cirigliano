<?php
/* @var $this RutaController */
/* @var $model Ruta */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Ruta')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Ruta.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Ruta.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Ruta.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Ruta.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Ruta.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Ruta.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'tipo_ruta_id',
		'mes',
		'created_at',
	),
)); ?>