<?php
setlocale(LC_ALL, 'es_ES');
//echo "desde: ".$desde.' hasta: '.$hasta;
$init_month = new DateTime("2014-10-01");
if(date('d') >= 25){
    $cur_month = new DateTime(date('Y-m-d',strtotime('+1 month')));    
}
else{
$cur_month = new DateTime(date('Y-m-d'));    
}
$interval = $cur_month->diff($init_month);
$dif_mes = -1*($interval->m-1);
//echo $dif_mes;
$meses=array();
if(date('d') >= 25){
    for($i=1; $i>=$dif_mes; $i--){
    $month = date('m-Y');
    $foo = explode('-', $month);
    $foo[0] = $foo[0]+$i;
    if($foo[0] < 1){
        $foo[0] = 13+$i;
        $foo[1] -= 1;
    }
    if($foo[0] > 12){
        $foo[0] = 1;
        $foo[1] += 1;
    }
    //echo "<br> ".date('m-Y').' '.$i.' '.$foo[0].'-'.$foo[1];
    $meses[date('m-Y',strtotime('1-'.$foo[0].'-'.$foo[1]))] = strftime("%B %Y", strtotime('1-'.$foo[0].'-'.$foo[1]));
    }
}
else{
    for($i=0; $i>=$dif_mes; $i--){
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
        <?php 
            $tabs=array();
            if (Yii::app()->user->checkAccess('Facturacion.Resumen')) {
                $tabs[] = array('label' => 'Resumen Reparaciones', 'view' => '_resumenReparaciones', 'viewData'=>array('presupuestos'=>$presupuestos,'presupuestosExcelencia'=>$presupuestosExcelencia),'active' =>$option == 1?true: false);
            }
            if (Yii::app()->user->checkAccess('Facturacion.Reparaciones')) {
                $tabs[] =array('label' => 'Reparaciones', 'view' => '_reparaciones','active' =>$option == 4?true: false);
            }
            if (Yii::app()->user->checkAccess('Facturacion.Traslados')) {
                $tabs[] =array('label' => 'Traslados', 'view' => '_traslados','active' =>$option == 5?true: false);
            }
            if (Yii::app()->user->checkAccess('Facturacion.Adicional')) {
                $tabs[] =array('label' => 'Adicionales', 'view' => '_adicionales','active' =>$option == 3?true: false);        
            }
            if (Yii::app()->user->checkAccess('Facturacion.ResumenExcelencia')) {
                $tabs[] =array('label' => 'Resumen Ruta Excelencia', 'view' => '_resumenExcelencia','active' =>$option == 2?true: false);
            
            }
        ?>
         <?php $this->widget('bootstrap.widgets.TbTabs', array(
            'tabs' => $tabs,
            'viewData'=>array('presupuestos'=>$presupuestos,'presupuestosExcelencia'=>$presupuestosExcelencia,'adicionales'=>$adicionales,'adicionalesDataProvider'=>$adicionalesDataProvider,'mes'=>$mes),
        )); ?>
    </div>

	
</div>