<?php
setlocale(LC_ALL, 'es_ES');
$meses=array();
if(date('d') >= 25){
    for($i=1; $i>0; $i--){
    $meses[date('m-Y',strtotime($i.' month'))] = strftime("%B %Y", strtotime($i.' month'));
    }
}
else{
    for($i=0; $i>-1; $i--){
    $meses[date('m-Y',strtotime($i.' month'))] = strftime("%B %Y", strtotime($i.' month'));
    }
}

 ?>
<div class="container-fluid">
	<h1>Facturación</h1>
    <div class="row">
        <h5>Periodo</h5>
        <?php 
            $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array( 
                'enableAjaxValidation'=>true, 'id'=>'formulario-form',
            ));
        ?>
        <div class="span2">
            <?php echo TbHtml::dropDownList('filtros[mes]', $mes, $meses); ?>
        </div>

        <div class="span2">
            <?php echo TbHtml::submitButton('Seleccionar Periodo',array('class'=>'btn-info')); ?>
        </div>
        <div class="span3">
            <?php echo CHtml::link(TbHtml::icon(TbHtml::ICON_DOWNLOAD_ALT,array('color'=>'white')).' Descargar Excel'
,array('Facturacion/ExportarExcel','mes'=>$mes),array('class'=>'btn btn-success')); ?>
            
        </div>

        <?php $this->endWidget(); ?>
                                         
    </div>
    <div class="row">
         <?php $this->widget('bootstrap.widgets.TbTabs', array(
            'tabs' => array(
                array('label' => 'Resumen Reparaciones', 'view' => '_resumenReparaciones', 'viewData'=>array('presupuestos'=>$presupuestos,'presupuestosExcelencia'=>$presupuestosExcelencia),'active' =>$option == 1?true: false),
                array('label' => 'Reparaciones', 'view' => '_reparaciones','active' =>$option == 4?true: false),
                array('label' => 'Traslados', 'view' => '_traslados','active' =>$option == 5?true: false),
                array('label' => 'Adicionales', 'view' => '_adicionales','active' =>$option == 3?true: false),
                array('label' => 'Resumen Ruta Excelencia', 'view' => '_resumenExcelencia','active' =>$option == 2?true: false),
            
            ),
            'viewData'=>array('presupuestos'=>$presupuestos,'presupuestosExcelencia'=>$presupuestosExcelencia,'adicionales'=>$adicionales,'adicionalesDataProvider'=>$adicionalesDataProvider,'mes'=>$mes),
        )); ?>
    </div>

	
</div>