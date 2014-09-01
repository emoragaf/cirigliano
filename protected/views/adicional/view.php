<?php
/* @var $this AdicionalController */
/* @var $model Adicional */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Adicional')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Adicional.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Adicional.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Adicional.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Adicional.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Adicional.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Adicional.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'mueble_presupuesto_id',
		'tarifa',
		'descripcion',
		'mueble_punto_id',
		'estado',
		'fecha_termino',
		'foto_id',
		'cantidad',
	),
)); ?>