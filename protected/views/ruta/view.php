<?php
/* @var $this RutaController */
/* @var $model Ruta */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Ruta')=>array('index'),
	$model->id,
);

$this->menu=array(
);
?>

<h1><?php echo Yii::t('app','model.Ruta.view');?></h1>
<?php setlocale(LC_TIME, 'es_ES'); ?>
<h3>Ruta <?php echo $model->tiporuta->nombre.', '.strftime("%B %Y",strtotime($model->mes)) ?></h3>
<table class="table table-bordered">
	<tr>
		<th>Punto</th>
	</tr>
<?php foreach ($puntos as $key => $punto): ?>
	<?php $p =Punto::model()->findByPk($key); ?>
	<tr>
		<td>
			<?php  echo $p->direccion; ?>
		</td>
	<?php foreach ($punto as $visita): ?>
		<td><?php echo $visita->estado == 0 ? CHtml::link('Agregar Visita', array('Ruta/CreateVisita','id'=>$visita->id)) : CHtml::link('Detalles Visita', array('Visita/View','id'=>$visita->visita_id))?></td>
	<?php endforeach ?>
	</tr>
<?php endforeach ?>
	
</table>