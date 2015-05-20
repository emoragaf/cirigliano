<?php $neto = 0;
$neto2 =0; ?>
<div class="row">
    <div style=" height:200px; overflow:auto;  ">
        <table class="table table-condensed table-bordered table-striped">
            <tr>
                <th>Folio</th>
                <th>Punto</th>
                <th>Fecha</th>
                <th>Mueble</th>
                <th>Elemento</th>
                <th>Cantidad</th>
                <th>Valor Unitario</th>
                <th>Total</th>
            </tr>
            <?php foreach ($presupuestos as $presupuesto): ?>
                <?php
                    $neto2+=$presupuesto->total;
                    $datosMueblePunto = array();

                    foreach ($presupuesto->mueblespresupuesto as $accion) {
                        if(isset($datosMueblePunto[$accion->mueble_punto_id]))
                            $datosMueblePunto[$accion->mueble_punto_id]['accion'][]=$accion;
                        else
                            $datosMueblePunto[$accion->mueble_punto_id]=array('accion'=>array($accion),'manobra'=>array(),'adicional'=>array());
                    }
                    foreach ($presupuesto->manosobra as $a) {
                        if(isset($datosMueblePunto[$a->mueble_punto_id]))
                            $datosMueblePunto[$a->mueble_punto_id]['manobra'][]=$a;
                        else
                            $datosMueblePunto[$a->mueble_punto_id]=array('accion'=>array(),'manobra'=>array($a),'adicional'=>array());
                    }
                    foreach ($presupuesto->adicionales as $adicional) {
                        if(isset($datosMueblePunto[$adicional->mueble_punto_id]))
                            $datosMueblePunto[$adicional->mueble_punto_id]['adicional'][]=$adicional;
                        else
                            $datosMueblePunto[$adicional->mueble_punto_id]=array('accion'=>array(),'manobra'=>array(),'adicional'=>array($adicional));
                    }
                ?>
                <?php if ($presupuesto->tarifa_visita_preventiva != null && $presupuesto->tarifa_visita_preventiva != 0): ?>
                    <tr>
                        <td><?php echo $presupuesto->visita->folio ?></td>
                        <td><?php echo $presupuesto->visita->punto->DireccionDescripcion ?></td>
                        <td><?php echo date('d-m-Y',strtotime($presupuesto->visita->fecha_visita)); ?></td>
                        <td>Visita Preventiva</td>
                        <td>Visita Preventiva</td>
                        <td>1</td>
                        <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$presupuesto->tarifa_visita_preventiva); ?></td>
                        <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$presupuesto->tarifa_visita_preventiva); ?></td>
                    </tr>
                    <?php $neto+=$presupuesto->tarifa_visita_preventiva; ?>
                <?php endif ?>
                <?php foreach ($datosMueblePunto as $mueblepuntoId => $value): ?>
                    <?php foreach ($value['accion'] as $accion): ?>
                        <tr>
                            <td><?php echo $accion->presupuesto->visita->folio ?></td>
                            <td><?php echo $accion->presupuesto->visita->punto->DireccionDescripcion ?></td>
                            <td><?php echo date('d-m-Y',strtotime($accion->presupuesto->visita->fecha_visita)); ?></td>
                            <td><?php echo $accion->mueblepunto->Descripcion; ?></td>
                            <td><?php echo $accion->servicio->descripcion; ?></td>
                            <td><?php echo $accion->cant_servicio; ?></td>
                            <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$accion->tarifa_servicio); ?></td>
                            <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$accion->cant_servicio*$accion->tarifa_servicio); ?></td>
                        </tr>
                        <?php $neto+=$accion->cant_servicio*$accion->tarifa_servicio; ?>
                    <?php endforeach ?>
                    <?php foreach ($value['adicional'] as $adicional): ?>
                        <tr>
                            <td><?php echo $adicional->presupuesto->visita->folio ?></td>
                            <td><?php echo $adicional->presupuesto->visita->punto->DireccionDescripcion ?></td>
                            <td><?php echo date('d-m-Y',strtotime($adicional->presupuesto->visita->fecha_visita)); ?></td>
                            <td><?php echo $adicional->mueblePunto->Descripcion; ?></td>
                            <td><?php echo $adicional->Descripcion; ?></td>
                            <td><?php echo $adicional->cantidad; ?></td>
                            <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$adicional->tarifa); ?></td>
                            <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$adicional->cantidad*$adicional->tarifa); ?></td>
                        </tr>
                        <?php $neto+=$adicional->cantidad*$adicional->tarifa; ?>
                    <?php endforeach ?>
                    <?php foreach ($value['manobra'] as $m): ?>
                         <tr>
                            <td><?php echo $m->presupuesto->visita->folio ?></td>
                            <td><?php echo $m->presupuesto->visita->punto->DireccionDescripcion ?></td>
                            <td><?php echo date('d-m-Y',strtotime($m->presupuesto->visita->fecha_visita)); ?></td>
                            <td><?php echo $m->mueblepunto->Descripcion; ?></td>
                            <td><?php echo $m->Descripcion; ?></td>
                            <td><?php echo 1; ?></td>
                            <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$m->Tarifa); ?></td>
                            <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',1*$m->Tarifa); ?></td>
                        </tr>
                        <?php $neto+=$m->Tarifa; ?>
                    <?php endforeach ?>
                <?php endforeach ?>
            <?php endforeach ?>
        </table>
    </div>
</div>
<br>
<div class="row well">
        <p><b>Neto: </b><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$neto); ?></p>
        <p><b>Iva: </b><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$neto*0.19); ?></p>
        <p><b>Total: </b><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$neto*1.19); ?></p>
</div>
