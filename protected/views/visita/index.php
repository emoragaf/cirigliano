<?php
/* @var $this VisitaController */
/* @var $dataProvider CActiveDataProvider */
?>
<div class="container-fluid">

	<h1><?php echo Yii::t('app','model.Visita')
	;?></h1>

	<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'visita-grid',
		'type'=>'bordered',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>array(
			array(
				'name'=>'punto_id',
				'value'=>'$data->punto->direccion'
				),
			array(
				'name'=>'fecha_creacion',
				'value'=>'date("d-m-Y",strtotime($data->fecha_creacion))'
				),
			array(
				'name'=>'tipo_visita_id',
				'value'=>'$data->tipoVisita->nombre',
				'filter'=>CHtml::listData(TipoVisita::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
			array(
				'name'=>'estado',
				'value'=>'$data->nombreEstado',
				'filter'=>$model->Estados,
				),
			array(
				'name'=>'fecha_visita',
				'value'=>'$data->fecha_visita !== null ? date("d-m-Y",strtotime($data->fecha_visita)) : ""'
				),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
			),
		),
	)); ?>

	
</div>