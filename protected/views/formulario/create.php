<?php
/* @var $this FormularioController */
/* @var $model Formulario */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Formulario')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Volver','url'=>array('visita/view','id'=>$visita->id)),
);
?>

<h1> <?php echo Yii::t('app','model.Formulario.create'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'MueblePresupuesto'=>$MueblePresupuesto,'Adicional'=>$Adicional,'TrasladoPresupuesto'=>$TrasladoPresupuesto,'campos'=>$campos,'visita'=>$visita)); ?>