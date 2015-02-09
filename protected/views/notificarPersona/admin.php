<?php
/* @var $this NotificarPersonaController */
/* @var $model NotificarPersona */


$this->breadcrumbs=array(
	Yii::t('app','model.Notificar Persona')
=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Acciones'),
	array('label'=>Yii::t('app','model.NotificarPersona.create'),'url'=>array('create')),
);
?>
<h2>Administrar Personas a Notificar</h2>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'notificar-persona-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'persona_id',
			'value'=>'$data->persona->nombre',
		),
		array(
			'name'=>'tipo_notificacion',
			'value'=>'$data->tipoNotificacion',
		),
		array(
			'name'=>'canal_id',
			'value'=>'$data->canal!=null?$data->canal->nombre : "Todos"',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{delete}',
		),
	),
)); ?>