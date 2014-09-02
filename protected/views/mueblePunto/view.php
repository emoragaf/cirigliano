<?php
/* @var $this MueblePuntoController */
/* @var $model MueblePunto */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Mueble Punto')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.MueblePunto.update'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('app','model.MueblePunto.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.ServicioMueble')),
	array('label'=>Yii::t('app','model.ServicioMueble.create'),'url'=>array('ServicioMueble/create','id'=>$model->mueble_id)),

);
?>

<h1><?php echo Yii::t('app','model.MueblePunto.view');?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
    	array(
    		'name'=>'mueble_id',
    		'value'=>$model->mueble->descripcion,
    		),
    	array(
    		'name'=>'punto_id',
    		'value'=>$model->punto->direccion,
    		),
		'codigo'
	),
)); ?>

<h2><?php echo Yii::t('app','model.ServicioMueble');?></h2>
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$servicios,
	'itemView'=>'_viewServicios',
)); ?>