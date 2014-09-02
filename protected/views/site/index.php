<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="span7 sidebar">

	<input type="text" placeholder="Buscar" class="span3">
	<select name="filtro" id="">
		<option value="Filtro 1">Filtro 1</option>
		<option value="Filtro 1">Opción 1</option>
		<option value="Filtro 1">Opción 2</option>
		<option value="Filtro 1">Opción 3</option>
	</select>
	<select name="filtro" id="">
		<option value="Filtro 1">Filtro 2</option>
		<option value="Filtro 1">Opción 1</option>
		<option value="Filtro 1">Opción 2</option>
		<option value="Filtro 1">Opción 3</option>
		<option value="Filtro 1">Opción 4</option>
	</select>
			
	<?php
		$this->widget('bootstrap.widgets.TbNav', array(
		    'type' => TbHtml::NAV_TYPE_TABS,
		    'stacked' => true,
		    'encodeLabel'=>false,
		    'htmlOptions'=>array('class'=>'bs-docs-sidenav'),
		    'items'=>$organizaciones,
		));
	?>
</div>
<div class="span5 sidebar">
	<?php
		$this->widget(
		'yiiwheels.widgets.box.WhBox',
		array(
		    'title'         => 'Nueva Visita 1',
		    'headerIcon'    => 'icon-info-sign',
		    'content'		=>'Punto 2. ',
		    'headerButtons' => array(
		        TbHtml::buttonGroup(
		            array(
		                array('label' => TbHtml::icon(TbHtml::ICON_OK_CIRCLE)),
		                array('label' => TbHtml::icon(TbHtml::ICON_EYE_CLOSE)),
		                array('label' => TbHtml::icon(TbHtml::ICON_REMOVE_CIRCLE)),
		            )
		        ),      
		    ),
		));
	?>
	<?php
		$this->widget(
		'yiiwheels.widgets.box.WhBox',
		array(
		    'title'         => 'Nueva Visita 2',
		    'headerIcon'    => 'icon-info-sign',
		    'content'		=>'Punto 5.',
		    'headerButtons' => array(
		        TbHtml::buttonGroup(
		            array(
		                array('label' => TbHtml::icon(TbHtml::ICON_OK_CIRCLE)),
		                array('label' => TbHtml::icon(TbHtml::ICON_EYE_CLOSE)),
		                array('label' => TbHtml::icon(TbHtml::ICON_REMOVE_CIRCLE)),
		            )
		        ),      
		    ),
		));
	?>

	
</div>
