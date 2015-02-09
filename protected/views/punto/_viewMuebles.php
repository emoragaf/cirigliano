<?php
/* @var $this PuntoController */
/* @var $data Punto */
?>

<div class="well">
  
	<b>Descripción:</b>
	<?php echo CHtml::link(CHtml::encode($data->mueble->descripcion),array('/mueblePunto/view','id'=>$data->id)); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::encode($data->codigo); ?>
	<br />
	<?php if (count($data->servicioMuebles) > 0): ?>
		<div id="accordion">
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $data->id; ?>">
		          Tarifa Elementos
		        </a>
		      </h4>
		    </div>

		    <?php $this->widget('bootstrap.widgets.TbCollapse',array(
			'view'=>'_viewElementos',
			'viewData'=>array('data'=>$data->servicioMuebles),
			'htmlOptions'=>array('id'=>'collapse'.$data->id),
			)); ?>
		  </div>
		</div>
	<?php endif ?>
</div>
	 