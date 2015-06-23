<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Visita')=>array('index'),
	$model->id,
);


$this->menu=array(
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('Presupuesto/create','id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('Presupuesto.create') && $model->estado == 0 && $model->tipo_visita_id != 3)? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.update'),'url'=>array('Presupuesto/update','id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('Presupuesto.update') &&$model->estado == 2 && $model->tipo_visita_id != 3)? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.create'),'url'=>array('Presupuesto/createTraslado','id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('Presupuesto.createTraslado') && $model->estado == 0 && $model->tipo_visita_id == 3)? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.update'),'url'=>array('Presupuesto/updateTraslado','id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('Presupuesto.updateTRaslado') && $model->estado == 2 && $model->tipo_visita_id == 3)? true : false),
	array('label'=>Yii::t('app','model.Visita.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>Yii::app()->user->checkAccess('Visita.delete')),
	array('label'=>Yii::t('app','model.Presupuesto.aceptar'),'url'=>array('Visita/AceptarPresupuesto','id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('Visita.aceptarPresupuesto') && $model->estado == 1) ? true : false),
	array('label'=>Yii::t('app','model.Presupuesto.rechazar'),'url'=>array('Visita/RechazarPresupuesto','id'=>$model->id),'visible'=>(Yii::app()->user->checkAccess('Visita.rechazarPresupuesto') && $model->estado == 1) ? true : false),
	array('label'=>Yii::t('app','model.Formulario'),'visible'=>Yii::app()->user->checkAccess('Formulario.create') && ($model->estado == 1 || $model->estado== 5)&& !isset($model->informe) ? true : false),

	array('label'=>Yii::t('app','model.Formulario.ingresarTrabajo'),'url'=>array('Formulario/create','id'=>$model->id),'visible'=>Yii::app()->user->checkAccess('Formulario.create') && ($model->estado == 1 || $model->estado== 5) && !isset($model->informe) ? true : false),
	array('label'=>'Informe','visible'=>Yii::app()->user->checkAccess('Informe.Download') && (Yii::app()->user->checkAccess('admin') && $model->estado != 0 && isset($model->informe)) || (!Yii::app()->user->checkAccess('admin') && Yii::app()->user->checkAccess('movistar_user') && $model->estado==4 && isset($model->presupuestos)) ? true : false),
	array('label'=>Yii::t('app','model.Formulario.update'),'url'=>array('Formulario/update','id'=>$model->informe!=null?$model->informe->id:null),'visible'=>Yii::app()->user->checkAccess('Formulario.update') && isset($model->informe) ? true : false),
	array('label'=>Yii::t('app','model.Visita.descargaPdf'),'url'=>array('Informe/Download','id'=>$model->id,'tipo'=>'pdf'),'visible'=>Yii::app()->user->checkAccess('Informe.Download') && (Yii::app()->user->checkAccess('admin') && $model->estado != 0 && isset($model->informe)) || (!Yii::app()->user->checkAccess('admin') && Yii::app()->user->checkAccess('movistar_user') && $model->estado==4 && isset($model->presupuestos)) ? true : false),
	array('label'=>Yii::t('app','model.Visita.descargaPpt'),'url'=>array('Informe/Download','id'=>$model->id,'tipo'=>'pptx'),'visible'=>Yii::app()->user->checkAccess('Informe.Download') && (Yii::app()->user->checkAccess('admin') && $model->estado != 0 && isset($model->informe)) || (!Yii::app()->user->checkAccess('admin') && Yii::app()->user->checkAccess('movistar_user') && $model->estado==4 && isset($model->presupuestos)) ? true : false)
);
?>
<style>
	img{
		margin: 6px;
	}
</style>
<h1><?php echo Yii::t('app','model.Visita.view');?></h1>


<table class="table table-condensed">
<?php if ($model->visita_preventiva): ?>
	<tr>
	<td colspan="3"><h4>Folio: <?php echo $model->folio; ?></h4></td>
	</tr>
	<tr>
		<td colspan="3"><h4><?php echo TbHtml::labelTb('Visita Preventiva', array('color' => TbHtml::LABEL_COLOR_INFO)); ?> Estado: <?php echo $model->nombreEstado; ?></h4></td>
	</tr>
<?php else: ?>
<tr>
	<td colspan="3"><h4>Folio: <?php echo $model->folio; ?></h4></td>
</tr>
<tr>
	<td colspan="3"><h4>Estado: <?php echo $model->nombreEstado; ?></h4></td>
</tr>
<?php endif ?>
<?php if ($model->tipo_visita_id == 3): ?>
	<tr>
		<td colspan="3"><h4>Origen: <?php echo $model->punto->DescripcionComuna; ?></h4></td>
	</tr>
	<tr>
		<td colspan="3"><h4>Destino: <?php echo $model->destino->DescripcionComuna; ?></h4></td>
	</tr>
<?php endif ?>
<tr>
	<td><b>Fecha Creación: <?php echo date("d-m-Y",strtotime($model->fecha_creacion)) ?></b></td>
	<td><b>Fecha Visita: <?php echo $model->fecha_visita !== null ? date("d-m-Y",strtotime($model->fecha_visita)) : 'No asignado' ?></b></td>
	<td><b>Solicitante: <?php echo $model->personaPunto->Nombre?></b></td>
	<td><b>Id Check: <?php echo $model->codigo?$model->codigo:'N/A'?></b></td>
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
				'type'=>'raw',
				'value'=>CHtml::link($model->punto->direccion,array('Punto/view','id'=>$model->punto->id)),
				),
			array(
				'name'=>'punto_canal_id',
				'value'=>isset($model->punto->canal) ? $model->punto->canal->nombre: null,
				),
			array(
				'name'=>'punto_subcanal_id',
				'value'=>isset($model->punto->subcanal) ? $model->punto->subcanal->nombre: null,
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
<?php if ( ($model->estado != 0 && isset($model->presupuestos))): ?>
<h4>Presupuesto</h4>
<?php foreach ($model->presupuestos as $presupuesto): ?>
	<?php
	$datosMueblePunto = array();

	foreach ($presupuesto->mueblespresupuesto as $accion) {
		if(isset($datosMueblePunto[$accion->mueble_punto_id]))
			$datosMueblePunto[$accion->mueble_punto_id]['accion'][]=$accion;
		else
			$datosMueblePunto[$accion->mueble_punto_id]=array('accion'=>array($accion),'manobra'=>array(),'traslado'=>array(),'adicional'=>array());
	}
	foreach ($presupuesto->manosobra as $a) {
		if(isset($datosMueblePunto[$a->mueble_punto_id]))
			$datosMueblePunto[$a->mueble_punto_id]['manobra'][]=$a;
		else
			$datosMueblePunto[$a->mueble_punto_id]=array('accion'=>array(),'manobra'=>array($a),'traslado'=>array(),'adicional'=>array());
	}
	foreach ($presupuesto->adicionales as $adicional) {
		if(isset($datosMueblePunto[$adicional->mueble_punto_id]))
			$datosMueblePunto[$adicional->mueble_punto_id]['adicional'][]=$adicional;
		else
			$datosMueblePunto[$adicional->mueble_punto_id]=array('accion'=>array(),'manobra'=>array(),'traslado'=>array(),'adicional'=>array($adicional));
	}
	foreach ($presupuesto->trasladopresupuesto as $traslado) {
		if(isset($datosMueblePunto[$traslado->mueble_punto]))
			$datosMueblePunto[$traslado->mueble_punto]['manobra'][]=$traslado;
		else
			$datosMueblePunto[$traslado->mueble_punto]=array('accion'=>array(),'manobra'=>array(),'traslado'=>array($traslado),'adicional'=>array());
	}
	?>
	<table class='table table-condensed table-bordered'>
		<tr>
			<th>Item</th>
			<th>Cantidad</th>
			<th>Tarifa</th>
			<th>Sub Total</th>
		</tr>
		<?php if ($presupuesto->tarifa_visita_preventiva): ?>
			<tr>
				<td>Visita Preventiva</td>
				<td>1</td>
				<td><?php echo $presupuesto->tarifa_visita_preventiva;?></td>
				<td><?php echo $presupuesto->tarifa_visita_preventiva;?></td>
			</tr>
		<?php endif ?>
		<?php if ($presupuesto->tarifasTraslado && $presupuesto->tipo_tarifa_traslado): ?>
			<?php foreach ($presupuesto->tarifasTraslado as $tm): ?>
				<tr>
					<td>Tarifa Traslado <?php echo$tm->tarifaTraslado->desde.' '.$tm->tarifaTraslado->hasta ?></td>
					<td>1</td>
					<td><?php echo $tm->TTraslado;?></td>
					<td><?php echo $tm->TTraslado;?></td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
		<?php foreach ($datosMueblePunto as $keyMueble => $datos): ?>
			<?php foreach ($datos['accion'] as $accion): ?>
			<tr>
				<td><?php echo $accion->servicio->mueble->descripcion.' '.$accion->servicio->descripcion ?></td>
				<td><?php echo $accion->cant_servicio ?></td>
				<td><?php echo $accion->tarifa_servicio ?></td>
				<td><?php echo $accion->tarifa_servicio*$accion->cant_servicio ?></td>
			</tr>
			<?php endforeach ?>
			<?php foreach ($datos['manobra'] as $manoobra): ?>
			<tr>
				<td><?php echo $manoobra->Descripcion?></td>
				<td></td>
				<td><?php echo $manoobra->Tarifa ?></td>
				<td><?php echo $manoobra->Tarifa ?></td>
			</tr>
			<?php endforeach ?>
			<?php foreach ($datos['adicional'] as $a): ?>
			<tr>
				<td><?php echo $a->Descripcion?></td>
				<td><?php echo $a->cantidad ?></td>
				<td><?php echo $a->tarifa ?></td>
				<td><?php echo $a->tarifa*$a->cantidad ?></td>
			</tr>
			<?php endforeach ?>
			<?php foreach ($datos['traslado'] as $t): ?>
				<?php if ($t->tarifa_instalacion != null): ?>
					<tr>
						<td><?php echo 'Instalación '.$t->mueblePunto->mueble->descripcion ?></td>
						<td>1</td>
						<td><?php echo $t->tarifa_instalacion ?></td>
						<td><?php echo $t->tarifa_instalacion ?></td>
					</tr>
				<?php endif ?>
				<?php if ($t->tarifa_desinstalacion != null): ?>
					<tr>
						<td><?php echo 'Desinstalación '.$t->mueblePunto->mueble->descripcion ?></td>
						<td>1</td>
						<td><?php echo $t->tarifa_desinstalacion ?></td>
						<td><?php echo $t->tarifa_desinstalacion ?></td>
					</tr>
				<?php endif ?>
				<?php if ($t->tarifa_desinstalacion == null && $t->tarifa_instalacion == null): ?>
					<tr>
						<td><?php echo $t->mueblePunto->mueble->descripcion ?></td>
						<td>1</td>
						<td>0</td>
						<td>0</td>
					</tr>
				<?php endif ?>
			<?php endforeach ?>
			<tr><td colspan="4"></td></tr>
		<?php endforeach ?>
		<tr>
		<td style="text-align: right;" colspan="3">Total: </td>
		<td><?php echo $presupuesto->total ?></td>
		</tr>
	</table>
<?php endforeach ?>
<?php endif ?>
<?php if ($model->informe): ?>
	<h4>Notas</h4>
	<div class="row well">
		<?php echo $model->informe->notas; ?>
	</div>
<?php endif; ?>

<?php if ( (Yii::app()->user->checkAccess('admin') && $model->estado != 0 && isset($model->informe)) || (!Yii::app()->user->checkAccess('admin') && (Yii::app()->user->checkAccess('movistar_user') || Yii::app()->user->checkAccess('movistar_lectura')) && $model->estado==4 && isset($model->presupuestos)) ): ?>

<h2>Fotos</h2>
<br>
	<?php
	$items = array();
	$itemsMuebles =array();
	foreach ($model->informe->fotos as $foto){
		if ($foto->tipo_foto_id == 3 || $foto->tipo_foto_id == 4 || $foto->tipo_foto_id == 5 ) {
			$url = Yii::app()->assetManager->publish($foto->foto->path.$foto->foto->id.'.'.$foto->foto->extension);
			$image = Yii::app()->image->load($foto->foto->path.$foto->foto->id.'.'.$foto->foto->extension);
			$image->resize(120, 120);
			$image->save($foto->foto->path.$foto->foto->id.'_thumb.'.$foto->foto->extension);
			$src = Yii::app()->assetManager->publish($foto->foto->path.$foto->foto->id.'_thumb.'.$foto->foto->extension);
			$items[] = array('url'=>$url,'src'=>$src, 'options'=>array('title'=>$foto->item_foto_id != null && $foto->tipo_foto_id != 3 && $foto->tipo_foto_id != 4 && $foto->tipo_foto_id != 5 ? strip_tags($foto->Item->Descripcion).' '.$foto->tipo->nombre : $foto->tipo->nombre));
		}
		if ($foto->tipo_foto_id != 3 && $foto->tipo_foto_id != 4 && $foto->tipo_foto_id != 5 ){
			$url = Yii::app()->assetManager->publish($foto->foto->path.$foto->foto->id.'.'.$foto->foto->extension);
			$image = Yii::app()->image->load($foto->foto->path.$foto->foto->id.'.'.$foto->foto->extension);
			$image->resize(120, 120);
			$image->save($foto->foto->path.$foto->foto->id.'_thumb.'.$foto->foto->extension);
			$src = Yii::app()->assetManager->publish($foto->foto->path.$foto->foto->id.'_thumb.'.$foto->foto->extension);
			$itemsMuebles[] = array('url'=>$url,'src'=>$src, 'options'=>array('title'=>$foto->item_foto_id != null && $foto->tipo_foto_id != 3 && $foto->tipo_foto_id != 4 && $foto->tipo_foto_id != 5 ? strip_tags($foto->Item->Descripcion).' '.$foto->tipo->nombre : $foto->tipo->nombre));
		}
	}
	?>
	<?php if (!empty($items)): ?>
		<div class="row well">
			<?php $this->widget('yiiwheels.widgets.gallery.WhGallery', array('items' => $items,'displayControls'=>true));?>
		</div>
	<?php endif ?>
	<?php if (!empty($itemsMuebles)): ?>
		<div class="row well">
			<?php $this->widget('yiiwheels.widgets.gallery.WhGallery', array('items' => $itemsMuebles,'displayControls'=>true));?>
		</div>
	<?php endif ?>
<?php endif ?>
