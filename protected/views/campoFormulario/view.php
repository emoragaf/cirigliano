<?php
/* @var $this CampoFormularioController */
/* @var $model CampoFormulario */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Campo Formulario')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.CampoFormulario.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.CampoFormulario.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.CampoFormulario.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.CampoFormulario.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.CampoFormulario.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.CampoFormulario.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'nombre',
		'tipo_visita_id',
		'tipo_campo_id',
	),
)); ?>