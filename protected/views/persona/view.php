<?php
/* @var $this PersonaController */
/* @var $model Persona */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Persona')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Persona.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Persona.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.Persona.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.Persona.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Persona.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app','model.Persona.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'nombre',
		'email',
		'telefono',
	),
)); ?>