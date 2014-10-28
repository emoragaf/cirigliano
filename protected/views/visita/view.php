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
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('Presupuesto/create','id'=>$model->id),'visible'=>($model->estado == 0 && $model->tipo_visita_id != 3)? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.update'),'url'=>array('Presupuesto/update','id'=>$model->id),'visible'=>($model->estado == 2 && $model->tipo_visita_id != 3)? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('Presupuesto/createTraslado','id'=>$model->id),'visible'=>($model->estado == 0 && $model->tipo_visita_id == 3)? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.update'),'url'=>array('Presupuesto/updateTraslado','id'=>$model->id),'visible'=>($model->estado == 2 && $model->tipo_visita_id == 3)? true : false),		
	array('label'=>Yii::t('app','model.Visita.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.Presupuesto.aceptar'),'url'=>array('Visita/AceptarPresupuesto','id'=>$model->id),'visible'=>$model->estado == 1 ? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.rechazar'),'url'=>array('Visita/RechazarPresupuesto','id'=>$model->id),'visible'=>$model->estado == 1 ? true : false),
	array('label'=>Yii::t('app','model.Formulario'),'visible'=>$model->estado == 1 && !isset($model->informe) ? true : false),
	array('label'=>Yii::t('app','model.Formulario.ingresarTrabajo'),'url'=>array('Formulario/create','id'=>$model->id),'visible'=>$model->estado == 1 && !isset($model->informe) ? true : false),
	array('label'=>'Informe','visible'=>isset($model->informe) ? true : false),
	array('label'=>Yii::t('app','model.Visita.descargaPdf'),'url'=>array('Informe/Download','id'=>$model->id,'tipo'=>'pdf'),'visible'=>isset($model->informe) ? true : false),
	array('label'=>Yii::t('app','model.Visita.descargaPpt'),'url'=>array('Informe/Download','id'=>$model->id,'tipo'=>'pptx'),'visible'=>isset($model->informe) ? true : false)
);
?>

<h1><?php echo Yii::t('app','model.Visita.view');?></h1>


<table class="table table-condensed">
<tr>
	<td colspan="3"><h4>Estado: <?php echo $model->nombreEstado; ?></h4></td>
</tr>
<tr>
	<td><b>Fecha Creación: <?php echo date("d-m-Y",strtotime($model->fecha_creacion)) ?></b></td>
	<td><b>Fecha Visita: <?php echo $model->fecha_visita !== null ? date("d-m-Y",strtotime($model->fecha_visita)) : 'No asignado' ?></b></td>
	<td><b>Solicitante: <?php echo $model->personaPunto->Nombre?></b></td>
</tr>
</table>
<h2>Datos Punto</h2>
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

<?php if ($model->estado != 0 && isset($model->presupuestos)): ?>
<h4>Presupuesto</h4>
<?php foreach ($model->presupuestos as $presupuesto): ?>
	<table class='table table-condensed table-bordered'>
		<tr>
			<th>Item</th>
			<th>Cantidad</th>
			<th>Tarifa</th>
			<th>Sub Total</th>
		</tr>
		<?php foreach ($presupuesto->mueblespresupuesto as $accion): ?>
		<tr>
			<td><?php echo $accion->servicio->mueble->descripcion.' '.$accion->mueblepunto->codigo.' '.$accion->servicio->descripcion ?></td>
			<td><?php echo $accion->cant_servicio ?></td>
			<td><?php echo $accion->tarifa_servicio ?></td>
			<td><?php echo $accion->tarifa_servicio*$accion->cant_servicio ?></td>
		</tr>
		</tr>
		<?php endforeach ?>
		<?php if ($presupuesto->tarifa_traslado && $presupuesto->tipo_tarifa_traslado): ?>
			<tr>
				<td>Tarifa Traslado</td>
				<td>1</td>
				<td><?php echo $presupuesto->TTraslado;?></td>
				<td><?php echo $presupuesto->TTraslado;?></td>
			</tr>
		<?php endif ?>
		<?php foreach ($presupuesto->trasladopresupuesto as $t): ?>
		<tr>
			<td><?php echo 'Instalación '.$t->mueblePunto->mueble->descripcion.' '.$t->mueblePunto->codigo?></td>
			<td>1</td>
			<td><?php echo $t->tarifa_instalacion ?></td>
			<td><?php echo $t->tarifa_instalacion ?></td>
		</tr>
		</tr>
		<?php endforeach ?>
		<tr>
		<td style="text-align: right;" colspan="3">Total: </td>
		<td><?php echo $presupuesto->total ?></td>
		</tr>
	</table>
	
<?php endforeach ?>

<?php endif ?>