<?php
/* @var $this ServicioMuebleController */
/* @var $model ServicioMueble */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Servicio Mueble')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.ServicioMueble.admin'),'url'=>array('admin')),
	array('label'=>Yii::t('app','model.ServicioMueble.create'),'url'=>array('create','id'=>$model->mueble_id)),
	array('label'=>Yii::t('app','model.ServicioMueble.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.ServicioMueble.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1><?php echo Yii::t('app','model.ServicioMueble.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'descripcion',
		'tarifa',
		array(
			'name'=>'mueble_id',
			'value'=>$model->mueble->descripcion,
		),
	),
)); ?>