<?php
/* @var $this PuntoController */
/* @var $model Punto */


$this->breadcrumbs=array(
	Yii::t('app','model.Punto')=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Punto.create'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#punto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
$data = array();
foreach (CHtml::listData(Comuna::model()->findAll(array('order'=>'nombre')), 'id', 'nombre') as $key => $value) {
	$data[]= array('id'=>$value,'text'=>$value);
}
?>
<h1><?php echo Yii::t('app','model.Punto'); ?></h1>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'punto-grid',
	'type'=>'bordered striped',
	'dataProvider'=>$model->search(),
	'afterAjaxUpdate'=>"function(id,data){ jQuery('#Punto_comuna_id').select2({'placeholder':'Comuna'}); jQuery('#Punto_distribuidor_id').select2({'placeholder':'Distribuidor'});}",
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{newVisita}',
			'buttons'=>array
		    (
		        'newVisita' => array
		        (
		            'label'=>'Nueva Visita',
		            'options'=>array('class'=>'btn'),
		            'icon'=>'icon-plus',
		            'url'=>'Yii::app()->createUrl("Visita/crear", array("id"=>$data->id))',
		        ),
		    ),
		),
		'direccion',
		array(
				'name'=>'region_id',
				'value'=>'isset($data->region) ? $data->region->nombre : null',
				'filter'=>CHtml::listData(Region::model()->findAll(array('order'=>'orden')), 'id', 'nombre'),
				),
		array(
				'name'=>'comuna_id',
				'value'=>'isset($data->comuna) ? $data->comuna->nombre : null',
				'filter'=>$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
					'name' => 'Punto[comuna_id]',
					'data' => array(''=>'',0=>'Todos') + CHtml::listData(Comuna::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
					'pluginOptions' => array(
			            'placeholder' => 'Comuna',
			            'allowClear' => true,
			            'width' => '100%'
		        	)
					),true),
				),
		array(
				'name'=>'canal_id',
				'value'=>'isset($data->canal) ? $data->canal->nombre : null',
				'filter'=>CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
				),
		array(
				'name'=>'distribuidor_id',
				'value'=>'isset($data->distribuidor) ? $data->distribuidor->nombre : null',
				'filter'=>$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
					'name' => 'Punto[distribuidor_id]',
					'data' => array(''=>'',0=>'Todos') + CHtml::listData(Distribuidor::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
					'pluginOptions' => array(
			            'placeholder' => 'Distribuidor',
			            'allowClear' => true,
			            'width' => '100%'
		        	)
				),true),
				),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
		),
	),
)); ?>