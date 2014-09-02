<?php
/* @var $this CampoFormularioController */
/* @var $model CampoFormulario */


$this->breadcrumbs=array(
	Yii::t('app','model.Campo Formulario')
=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.CampoFormulario.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.CampoFormulario.create'),'url'=>array('create')),
);
?>


<h1><?php echo Yii::t('app','model.CampoFormulario.admin'); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'campo-formulario-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'entidad',
		'nombre',
		'tipo_visita_id',
		'tipo_campo_id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>