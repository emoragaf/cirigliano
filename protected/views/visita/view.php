<?php
/* @var $this VisitaController */
/* @var $model Visita */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Visita')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Visita.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('Presupuesto/create','id'=>$model->id),'visible'=>($model->estado == 0)? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.update'),'url'=>array('Presupuesto/update','id'=>$model->id),'visible'=>($model->estado == 2)? true : false),			
	array('label'=>Yii::t('app','model.Presupuesto.aceptar'),'url'=>array('Presupuesto/AceptarPresupuesto','id'=>$model->id),'visible'=>$model->estado == 1 ? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.rechazar'),'url'=>array('Presupuesto/RechazarPresupuesto','id'=>$model->id),'visible'=>$model->estado == 1 ? true : false),

	array('label'=>Yii::t('app','model.Visita.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1><?php echo Yii::t('app','model.Visita.view');?></h1>

<h3>Estado: <?php echo $model->nombreEstado; ?></h3>
<h4>Fecha Creación: <?php echo date("d-m-Y",strtotime($model->fecha_creacion)) ?></h4>
<h4>Fecha Visita: <?php echo $model->fecha_visita !== null ? date("d-m-Y",strtotime($model->fecha_visita)) : 'No asignado' ?></h4>
<h4>Solicitante: <?php echo $model->personaPunto->Nombre?></h4>

<h1>Datos Punto</h1>
<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-bordered',
    ),
    'data'=>$model,
    'attributes'=>array(
			array(
				'name'=>'punto_direccion',
				'value'=>$model->punto->direccion,
				),
			array(
				'name'=>'punto_canal_id',
				'value'=>isset($model->punto->canal) ? $model->punto->canal->nombre: null,
				),
			array(
				'name'=>'punto_distribuidor_id',
				'value'=>isset($model->punto->distribuidor) ? $model->punto->distribuidor->nombre: null,
				),
			array(
				'name'=>'punto_region_id',
				'value'=>isset($model->punto->region) ? $model->punto->region->nombre : null,
				),
			array(
				'name'=>'punto_comuna_id',
				'value'=>isset($model->punto->comuna) ? $model->punto->comuna->nombre :null,
				),
			array(
				'name'=>'tipo_visita_id',
				'value'=>$model->tipoVisita->nombre,
				),
	),
)); ?>

<?php if ($model->estado != 0 && $model->estado !=3 && isset($model->presupuestos)): ?>
<h4>Presupuesto</h4>
<?php foreach ($model->presupuestos as $presupuesto): ?>
	<table class='table table-condensed table-bordered'>
		<tr>
			<th>Item</th>
			<th>Tarifa</th>
		</tr>
		<?php foreach ($presupuesto->mueblespresupuesto as $accion): ?>
		<tr>
			<td><?php echo $accion->servicio->mueble->descripcion.' '.$accion->mueblepunto->codigo.' '.$accion->servicio->descripcion ?></td>
			<td><?php echo $accion->servicio->tarifa ?></td>
		</tr>
		<?php endforeach ?>
		<tr>
		<td style="text-align: right;">Total: </td>
		<td><?php echo $presupuesto->total ?></td>
		</tr>
	</table>
	
<?php endforeach ?>

<?php endif ?>